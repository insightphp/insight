<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Component;
use Insight\Resources\PanelFactory;
use Insight\View\Layouts\ResourceDetailLayout;
use Insight\View\Pages\ShowResourcePage;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CanBeViewed
{
    /**
     * Creates new panel factory for the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Resources\PanelFactory
     */
    public function newPanel(Model $model): PanelFactory
    {
        return new PanelFactory($this, $model);
    }

    /**
     * Retrieve the title for detail panel.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string|null
     */
    public function getTitleForDetailPanel(Model $model): ?string
    {
        return 'Details';
    }

    /**
     * Creates new detail page for the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\View\Pages\ShowResourcePage
     */
    public function toDetailPage(Model $model): ShowResourcePage
    {
        return new ShowResourcePage($this, $model);
    }

    /**
     * Creates new detail page layout for the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Inertia\View\Component|null
     */
    public function createDetailLayout(Model $model): ?Component
    {
        return new ResourceDetailLayout($this, $model);
    }
}
