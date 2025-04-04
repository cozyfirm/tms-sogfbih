<?php

namespace App\Providers;

use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Trainings\Training;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider{
    /**
     * Register services.
     */
    public function register(): void{
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void{
        $availableTrainings = Instance::where('application_date','>=', date('Y-m-d'))->count();

       view()->share('availableTrainings', $availableTrainings);
    }
}
