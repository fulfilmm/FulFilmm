<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('can-acknowledge', function($employee, $acknowledged_data) {
            #check if requested employee is the owner of acknowledged
            if ($acknowledged_data->employee_id == Auth::guard('employee')->id()) {
                return true;
            }
            # check requested employee is the reported supervisor
            return $employee->id == $acknowledged_data->report_to_employee_id ? true : false;
        });
    }
}
