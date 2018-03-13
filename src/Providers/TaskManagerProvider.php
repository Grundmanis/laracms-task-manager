<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Providers;

use Grundmanis\Laracms\Modules\Pages\Exception\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class TaskManagerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'laracms.tasks');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadRoutesFrom(__DIR__ . '/../laracms_task_routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../laracms_task_project_routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../laracms_task_history_routes.php');
    }

}
