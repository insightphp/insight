<?php


namespace Insight\Inertia\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ComponentManager;

class SurfaceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('surface.components', fn () => new ComponentManager());
        $this->app->alias('surface.components', ComponentManager::class);
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/surface.php', 'surface');

        $this->publishes([
            __DIR__ . '/../../config/surface.php' => config_path('surface.php'),
        ], 'surface');

        $this->registerComponentsFromConfig(config('surface.components', []));
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
