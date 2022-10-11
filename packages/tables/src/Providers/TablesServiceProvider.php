<?php


namespace Insight\Tables\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ComponentManager;

class TablesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViewComponents(app(ComponentManager::class));
    }

    protected function registerViewComponents(ComponentManager $componentManager)
    {
        $componentManager->addComponentsFromPath(__DIR__.'/../View/Components', 'insight-tables');
    }
}
