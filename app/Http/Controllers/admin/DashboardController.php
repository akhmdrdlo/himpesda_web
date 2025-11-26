<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Himpunan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard berdasarkan level pengguna.
     */
    public function index(Request $request) 
    {
        $user = Auth::user();

        // 1. JIKA USER ADALAH STAF ADMIN (admin, operator, operator_daerah, bendahara, bendahara_daerah)
        if (in_array($user->level, ['admin', 'operator', 'operator_daerah', 'bendahara', 'bendahara_daerah'])) {            
            $organisasi = Himpunan::firstOrCreate([]);
            $provinsiList = [];
            $selectedProvinsi = $request->get('provinsi');
            $statsQuery = User::whereIn('level', ['anggota', 'operator_daerah', 'bendahara_daerah']);
            // --- PERBAIKAN LOGIKA STATISTIK PROVINSI ---
            $provinsiStatsQuery = User::whereIn('level', ['anggota', 'operator_daerah', 'bendahara_daerah']);
            
            if ($user->level == 'admin') {
                $provinsiList = User::whereNotNull('provinsi')
                    ->where('provinsi', '!=', '')->distinct()->orderBy('provinsi')->pluck('provinsi');
                if ($selectedProvinsi) {
                    $statsQuery->where('provinsi', $selectedProvinsi);
                }
            }
            elseif (in_array($user->level, ['operator_daerah', 'bendahara_daerah'])) {
                $statsQuery->where('provinsi', $user->provinsi);
                $provinsiStatsQuery->where('provinsi', $user->provinsi);
            }

            // ... (Statistik Gender, Status, Jabatan tetap sama) ...
            $jumlahLaki = (clone $statsQuery)->where('jenis_kelamin', 'Laki-laki')->count();
            $jumlahPerempuan = (clone $statsQuery)->where('jenis_kelamin', 'Perempuan')->count();
            $anggotaAktif = (clone $statsQuery)->where('status_pengajuan', 'active')->count();
            $anggotaTidakAktif = (clone $statsQuery)->whereIn('status_pengajuan', ['pending', 'awaiting_payment', 'payment_review', 'rejected'])->count();
            $jabatanStats = (clone $statsQuery)
                ->whereNotNull('jabatan_fungsional')->where('jabatan_fungsional', '!=', '')
                ->groupBy('jabatan_fungsional')->select('jabatan_fungsional', DB::raw('count(*) as total'))
                ->get();
            $jabatanLabels = $jabatanStats->pluck('jabatan_fungsional');
            $jabatanCounts = $jabatanStats->pluck('total');

            
            $provinsiStats = $provinsiStatsQuery
                ->whereNotNull('provinsi')->where('provinsi', '!=', '')
                ->groupBy('provinsi')
                ->select('provinsi', DB::raw('count(*) as total'))
                ->orderBy(DB::raw('count(*)'), 'desc') 
                ->get();
            
            $provinsiLabels = $provinsiStats->pluck('provinsi');
            $provinsiCounts = $provinsiStats->pluck('total');
            $totalAnggota = $provinsiCounts->sum(); 
            
            // --- Kirim mereka ke view 'admin.dashboard' (Layout Admin) ---
            return view('admin.dashboard', compact(
                'organisasi', 'jumlahLaki', 'jumlahPerempuan',
                'anggotaAktif', 'anggotaTidakAktif',
                'jabatanLabels', 'jabatanCounts',
                'provinsiLabels', 'provinsiCounts', 'totalAnggota',
                'provinsiList', 'selectedProvinsi'
            ));
        }

        // 2. JIKA USER ADALAH 'anggota'
        elseif ($user->level == 'anggota') {       
            // --- Kirim mereka ke view 'dashboard' (Layout Anggota/Tracer) ---
            return view('admin.dashboard');
        }

        // 3. Fallback
        else {
            Auth::logout();
            return redirect('/login')->with('error', 'Level pengguna tidak dikenali.');
        }
    }
}