<?php

namespace App\Providers;

use App;
use URL;
use Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // foreach (glob(__DIR__.'/../Core/Helpers/*.php') as $filename) {
        //     require_once $filename;
        // }
        Schema::defaultStringLength(191);
        ini_set('memory_limit', '2048M');
        ini_set('post_max_size ', '2048M');
        ini_set('upload_max_filesize ', '2048M');
        ini_set('max_execution_time', 900);
        set_time_limit(3000);
        if (App::environment(['local','staging'])) {
            Config::set('auth.passwords.users.throttle', 0);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
