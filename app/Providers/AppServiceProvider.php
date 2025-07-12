<?php

namespace App\Providers;

use App\Models\User; // <-- PASTIKAN BARIS INI BENAR, mengarah ke App\Models\User
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definisi Gate untuk hak akses berita
        // PASTIKAN TYPE HINT DI SINI JUGA BENAR: (User $user)
        Gate::define('create-news', function (User $user) {
            dd($user->level); 
            return in_array($user->level, ['admin', 'operator']);
        });
    }
}