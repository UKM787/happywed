<?php

namespace App\Providers;

use App\Models\Location;
use App\Wed\Happy;
use App\Wed\WedMacros;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin\LocationMasterMaster;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
            Happy::mixin(new WedMacros());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        //$locations = Location::all();
        //View::share('locations', $locations);

    }
}
