<?php


namespace Insight\View\Pages;


use Insight\Facades\Insight;
use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Page;

class InsightPage extends Page
{

    #[Computed(name: '_layouts')]
    public function getLayouts(): ?array
    {
        $globalLayouts = Insight::getLayouts();

        $pageLayouts = $this->getLayoutStack();

        $layouts = $globalLayouts->addFrom($pageLayouts);

        if ($layouts->isEmpty()) {
            return null;
        }

        return $layouts->getLayouts();
    }

}
