<?php


namespace Insight\Inertia\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ComponentManager;

class InertiaViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('inertia-view.components', fn () => new ComponentManager());
        $this->app->alias('inertia-view.components', ComponentManager::class);
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/inertia-view.php', 'inertia-view');

        $this->publishes([
            __DIR__ . '/../../config/inertia-view.php' => config_path('inertia-view.php'),
        ], 'inertia-view');

        $this->registerComponentsFromConfig(config('inertia-view.components', []));
    }

    protected function registerComponentsFromConfig(array $components)
    {
        /** @var ComponentManager $manager */
        $manager = $this->app->make(ComponentManager::class);

        foreach ($components as $namespace => $path) {
            if (is_string($path)) {
                $manager->addComponentsFromPath($path, $namespace);
            } else if (is_array($path)) {
                foreach ($path as $directory) {
                    $manager->addComponentsFromPath($directory, $namespace);
                }
            }
        }
    }
}
