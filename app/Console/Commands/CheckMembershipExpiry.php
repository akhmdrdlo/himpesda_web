<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckMembershipExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-membership-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Ambil Anggota Aktif yang Masa Berlakunya Habis (Activated_at + 1 Tahun < Hari Ini)
        // expiredDate adalah batas tanggal. Jika user diaktivasi SEBELUM expiredDate, berarti sudah > 1 tahun.
        $expiredDate = now()->subYear();

        // Cek activated_at utama, jika null (user lama) cek created_at
        $expiredUsers = \App\Models\User::where('status_pengajuan', 'active')
            ->where(function ($query) use ($expiredDate) {
                $query->where('activated_at', '<', $expiredDate)
                      ->orWhere(function ($q) use ($expiredDate) {
                          $q->whereNull('activated_at')
                            ->where('created_at', '<', $expiredDate);
                      });
            })
            ->get();

        $count = 0;

        foreach ($expiredUsers as $user) {
            $user->update([
                'status_pengajuan' => 'awaiting_payment'
            ]);
            $this->info("Expired: {$user->nama_lengkap} (Join: {$user->created_at->format('d-m-Y')})");
            $count++;
        }

        if ($count > 0) {
            $this->info("Berhasil! {$count} anggota telah diganti statusnya menjadi awaiting_payment (Masa Aktif Habis).");
        } else {
            $this->info('Tidak ada anggota yang masa aktifnya habis hari ini.');
        }
    }
}
