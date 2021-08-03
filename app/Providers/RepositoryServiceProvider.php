<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $models = ['Department','Company', 'Customer', 'Activity', 'ActivityTask', 'Assignment','AssignmentTask', 'Project', 'ProjectTask'];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->models as $model) {
            $this->app->bind("App\Repositories\Contracts\\{$model}Contract",
                "App\Repositories\\{$model}Repository");
        }

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
