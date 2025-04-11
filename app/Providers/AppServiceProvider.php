<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\{
    EnrollForm, EnrollFormSteps, CommunicationForm
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Livewire::component('enroll-form', EnrollForm::class);
        Livewire::component('enroll-form-steps', EnrollFormSteps::class);
        Livewire::component('communication-form', CommunicationForm::class);
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        //
    }
}
