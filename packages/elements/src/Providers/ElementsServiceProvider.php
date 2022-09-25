<?php


namespace Insight\Elements\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ComponentManager;

class ElementsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViewComponents(app(ComponentManager::class));
    }

    protected function registerViewComponents(ComponentManager $componentManager)
    {
        $componentManager->registerComponentsIn(__DIR__ . '/../', 'insight-elements');
    }
}
