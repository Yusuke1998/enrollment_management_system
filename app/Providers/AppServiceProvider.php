<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\EnrollForm;
use App\Http\Livewire\EnrollFormSteps;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Livewire::component('enroll-form', EnrollForm::class);
        Livewire::component('enroll-form-steps', EnrollFormSteps::class);
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        //
    }
}
