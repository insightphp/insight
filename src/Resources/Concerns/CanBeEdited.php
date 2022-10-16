<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Page;
use Insight\View\Pages\ResourceFormPage;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CanBeEdited
{
    /**
     * Creates new create page for the resource.
     *
     * @return \Insight\Inertia\View\Page
     */
    public function toCreatePage(): Page
    {
        return new ResourceFormPage($this);
    }

    /**
     * Creates new edit page for the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Inertia\View\Page
     */
    public function toEditPage(Model $model): Page
    {
        return new ResourceFormPage($this, $model);
    }
}
