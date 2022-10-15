<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;
use Insight\Panels\View\Components\Panel;

class PanelFactory
{
    public function __construct(
        protected Resource $resource,
        protected Model $model
    ) {}

    /**
     * Create new details panel.
     *
     * @return \Insight\Panels\View\Components\Panel
     */
    public function getDetailsPanel(): Panel
    {
        $panel = Panel::make();

        return $panel;
    }
}
