<?php

namespace App\Providers;

use App\FileProcessor\FileNameGenerator;
use App\FileProcessor\LocalFileNameGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        FileNameGenerator::class => LocalFileNameGenerator::class
    ];

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
        //
    }
}
