<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class RegionalScope implements Scope
{
    /**
     * Terapkan scope ke query builder.
     * Ini adalah Fase 2.2 dari Rencana Revisi.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Periksa apakah ada user yang sedang login
        if (Auth::check()) {
            $user = Auth::user();

            // Jika user adalah 'operator_daerah', filter query
            if ($user->level === 'operator_daerah') {
                // Asumsikan model yang di-query memiliki kolom 'provinsi'
                // dan operator_daerah memiliki provinsi yang terdefinisi
                if (!empty($user->provinsi)) {
                    $builder->where('provinsi', $user->provinsi);
                } else {
                    // Jika operator daerah tidak punya provinsi, jangan tampilkan apa-apa
                    $builder->whereRaw('1 = 0'); 
                }
            }
            // Jika 'admin', 'bendahara', 'operator' (pusat), atau 'anggota',
            // scope tidak diterapkan, sehingga mereka bisa melihat semua data.
        }
    }
}