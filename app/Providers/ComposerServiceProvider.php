<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('backend.draws.create', \App\Http\Composers\PrizeTypes::class);
        View::composer('index', \App\Http\Composers\DrawResults::class);
    }
}
