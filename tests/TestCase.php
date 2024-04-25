<?php

namespace GridPrinciples\ContentBlocks\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use GridPrinciples\ContentBlocks\ContentBlocksServiceProvider;
use GridPrinciples\ContentBlocks\Facades\ContentBlocks;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'GridPrinciples\\ContentBlocks\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ContentBlocksServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        ContentBlocks::loadBlocks('GridPrinciples\\ContentBlocks\\Tests\\Fake', __DIR__.'/Fake/*');
    }
}
