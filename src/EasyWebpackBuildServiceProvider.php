<?php

namespace Sabatino\EasyWebpackBuild;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EasyWebpackBuildServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    }
}
