<?php


namespace Insight\Inertia\Tests;


use Insight\Inertia\Providers\SurfaceServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SurfaceServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('surface.components', [
            'surface' => __DIR__ . '/Fixtures/Components'
        ]);
    }
}
