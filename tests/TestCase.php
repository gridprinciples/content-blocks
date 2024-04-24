<?php

namespace GridPrinciples\ContentBlocks\Tests;

use GridPrinciples\ContentBlocks\ContentBlocksServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

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
        config()->set('database.default', 'testing');

        config()->set('content-blocks.load_blocks_from', [
            'GridPrinciples\\ContentBlocks\\Tests\\Fake' => __DIR__.'/Fake/*',
        ]);

        /*
        $migration = include __DIR__.'/../database/migrations/create_content-blocks_table.php.stub';
        $migration->up();
        */
    }
}
