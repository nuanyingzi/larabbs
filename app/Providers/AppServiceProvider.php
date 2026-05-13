<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Topic;
use App\Observers\TopicObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		// \App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);
		// \App\Models\Project::observe(\App\Observers\ProjectObserver::class);
        \Illuminate\Pagination\Paginator::useBootstrap();
        // 监听Topic模型的事件
        Topic::observe(TopicObserver::class);
    }
}
