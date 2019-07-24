<?php

namespace App\Providers;

use App\Models\Article;
use App\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Article::observe(ArticleObserver::class);//注册文章模型事件观察器
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {   
        //如果开发环境是在本地环境加载
        if ($this->app->environment() == 'local') {

        
        }
        
    }
}
