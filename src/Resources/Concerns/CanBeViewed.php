<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\View\Pages\ShowResourcePage;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CanBeViewed
{
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
}
