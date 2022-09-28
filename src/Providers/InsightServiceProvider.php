<?php


namespace Insight\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ComponentManager;

class InsightServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/insight.php', 'insight');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/insight.php' => config_path('insight.php')
        ], 'insight-config');

        $this->registerRoutes();
        $this->registerInertiaViews();
    }

    /**
     * Register all Inertia Components.
     *
     * @return void
     */
    protected function registerInertiaViews(): void
    {
        app(ComponentManager::class)->addComponentsFromPath(__DIR__.'/../View/Components', 'insight');
        app(ComponentManager::class)->addComponentsFromPath(__DIR__.'/../View/Layouts', 'insight');
    }

    /**
     * Register all Insight routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        Route::middlewareGroup('insight', config('insight.middleware', []));

        Route::group($this->resolveRoutesConfiguration(), fn () => $this->loadRoutesFrom(__DIR__.'/../../routes/routes.php'));
    }

    /**
     * Resolve configuration for routes provided by Insight.
     *
     * @return string[]
     */
    protected function resolveRoutesConfiguration(): array
    {
        $configuration = [
            'middleware' => 'insight',
        ];

        $prefix = config('insight.prefix');

        if ($prefix) {
            $configuration['prefix'] = $prefix;
        }

        return $configuration;
    }
}
