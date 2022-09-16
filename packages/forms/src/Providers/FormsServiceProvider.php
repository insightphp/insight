<?php


namespace Insight\Forms\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Inertia\ViewComponentManager;

class FormsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViewComponents(app(ViewComponentManager::class));
    }

    protected function registerViewComponents(ViewComponentManager $componentManager)
    {
        $componentManager->registerComponentsIn(__DIR__ . '/../View/Components', 'insight-forms');
    }
}
