<?php

namespace App\Providers;

use App\Journal;
use App\Liste;
use App\Observers\JournalObserver;
use App\Observers\ListObserver;
use App\Observers\PostObserver;
use App\Post;
use MadWeb\Robots\RobotsFacade;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RobotsFacade::setShouldIndexCallback(function () {
            return app()->environment('production');
        });
        Liste::observe(ListObserver::class);
        Post::observe(PostObserver::class);
        Journal::observe(JournalObserver::class);
    }
}
