<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Insight\Inertia\View\Page;
use Insight\Resources\Creator;
use Insight\Resources\FormFactory;
use Insight\Resources\Updater;
use Insight\View\Pages\ResourceFormPage;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CanBeEdited
{
    /**
     * Creates new form factory for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return \Insight\Resources\FormFactory
     */
    public function newForm(Request $request, ?Model $model = null): FormFactory
    {
        return new FormFactory($request, $this, $model);
    }

    /**
     * Creates new create page for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Insight\Inertia\View\Page
     */
    public function toCreatePage(Request $request): Page
    {
        return new ResourceFormPage($request, $this);
    }

    /**
     * Creates new resource creator.
     *
     * @return \Insight\Resources\Creator
     */
    public function newCreator(): Creator
    {
        return new Creator($this);
    }

    /**
     * Creates new edit page for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Inertia\View\Page
     */
    public function toEditPage(Request $request, Model $model): Page
    {
        return new ResourceFormPage($request, $this, $model);
    }

    /**
     * Creates new resource updater.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Resources\Updater
     */
    public function newUpdater(Model $model): Updater
    {
        return new Updater($this, $model);
    }
}
