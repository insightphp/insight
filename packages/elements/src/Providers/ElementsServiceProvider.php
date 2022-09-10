<?php


namespace Insight\Elements\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ViewComponentManager;

class ElementsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViewComponents(app(ViewComponentManager::class));
    }

    protected function registerViewComponents(ViewComponentManager $componentManager)
    {
        $componentManager->registerComponentsIn(__DIR__ . '/../', 'insight-elements');
    }
}
