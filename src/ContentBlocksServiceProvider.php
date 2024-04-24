<?php

namespace GridPrinciples\ContentBlocks;

use Illuminate\Support\ServiceProvider;

class ContentBlocksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/content-blocks.php', 'content-blocks');

        $this->app->singleton(BlockManager::class, function () {
            return new BlockManager;
        });
    }
}
