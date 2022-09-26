<?php


namespace Insight\Inertia\Tests;


use Insight\Inertia\Providers\InertiaViewServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            InertiaViewServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('view.paths', [
            __DIR__ . '/Fixtures/Views'
        ]);

        config()->set('inertia-view.components', [
            'inertia-view' => __DIR__ . '/Fixtures/Components'
        ]);
    }
}
