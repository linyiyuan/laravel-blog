<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuListProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //分配后台导航列表
        View::composer(
          ['common/menu'], 'App\Http\ViewComposers\MenuListComposer'
         );

        View::composer(
          ['common/header'], 'App\Http\ViewComposers\BackstageHeader'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
