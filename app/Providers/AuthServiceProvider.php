<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Backup' => 'App\Policies\BackupPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define las habilidades (abilities) aquí
        Gate::define('admin.backups.list', function ($user) {
            return $user->hasPermissionTo('admin.backups.list');
        });

        Gate::define('admin.backups.create', function ($user) {
            return $user->hasPermissionTo('admin.backups.create');
        });

        Gate::define('admin.backups.delete', function ($user) {
            return $user->hasPermissionTo('admin.backups.delete');
        });
    }
}
