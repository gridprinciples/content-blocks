<?php

namespace GridPrinciples\ContentBlocks;

use Illuminate\Support\ServiceProvider;

class ContentBlocksServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BlockManager::class, fn () => new BlockManager);
    }
}
