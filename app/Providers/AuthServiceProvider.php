<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        $gate->define('isAdmin', function ($user){
            return $user->type == 'admin';
        });
        $gate->define('isOperator', function ($user){
            return $user->type == 'operator';
        });
        $gate->define('isUser', function ($user){
            return $user->type == 'user';
        });
        $gate->define('isSupplier', function ($user){
            return $user->type == 'supplier';
        });
        $gate->define('isCustomer', function ($user){
            return $user->type == 'customer';
        });
    }
}
