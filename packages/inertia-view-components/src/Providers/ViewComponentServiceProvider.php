<?php


namespace Insight\Inertia\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ViewComponentManager;

class ViewComponentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ViewComponentManager::class, fn () => new ViewComponentManager());
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/inertia-view-components.php', 'inertia-view-components');

        $this->publishes([
            __DIR__ . '/../../config/inertia-view-components.php' => config_path('inertia-view-components.php'),
        ], 'inertia-view-components');

        /** @var ViewComponentManager $manager */
        $manager = $this->app->get(ViewComponentManager::class);

        foreach (config('inertia-view-components.components', []) as $namespace => $components) {
            if (is_string($components) && file_exists($components)) {
                $manager->registerComponentsIn($components, $namespace);
            }

            if (is_iterable($components)) {
                foreach ($components as $path) {
                    if (file_exists($path)) {
                        $manager->registerComponentsIn($path, $namespace);
                    }
                }
            }
        }
    }
}
