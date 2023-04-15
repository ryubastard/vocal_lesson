<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers\ReservationsComposer;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['profile.show', 'profile.delete-user-form'],
            ReservationsComposer::class
        );
    }
}
