<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        // Vamos a definir las 'gates' que nos permitirán identificar qué rol tiene 
        // cada usuario y qué puede hacer en el sistema.

        Gate::define('capturar-cv', function($user) {
            return $user->hasRole('profesor');
        });

        Gate::define('registrar-profesor', function($user) {
            return $user->hasAnyRoles(['control_escolar', 'admin']);
        });

        Gate::define('buscar-profesor', function($user) {
            return $user->hasAnyRoles(['control_escolar', 'admin']);
        });

        Gate::define('descargar-cv', function($user) {
            return $user->hasAnyRoles(['control_escolar', 'admin']);
        });

        Gate::define('registrar-encargado-ce', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('registrar-admin', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('registrar-usuario', function($user) {
            return $user->hasAnyRoles(['control_escolar', 'admin']);
        });
    }
}
