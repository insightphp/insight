<?php


namespace Insight\Resources\Fields\Concerns;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Insight\Resources\Resource;

trait ControlsVisibility
{
    /**
     * Determine if the field is visible on list.
     *
     * @var string|\Closure|bool|null
     */
    protected string|\Closure|bool|null $visibleOnList = null;

    /**
     * Determine if the field is visible on detail.
     *
     * @var string|\Closure|bool|null
     */
    protected string|\Closure|bool|null $visibleOnDetail = null;

    /**
     * Determine if the field is visible on create form.
     *
     * @var string|\Closure|bool|null
     */
    protected string|\Closure|bool|null $visibleOnCreate = null;

    /**
     * Determine if the field is visible on update form.
     *
     * @var string|\Closure|bool|null
     */
    protected string|\Closure|bool|null $visibleOnUpdate = null;

    /**
     * Determines if the field is visible on the list.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function isVisibleOnList(Resource $resource, Model $model): bool
    {
        if ($this->visibleOnList instanceof \Closure) {
            return value($this->visibleOnList, $resource, $model);
        }

        if (is_bool($this->visibleOnList)) {
            return $this->visibleOnList;
        }

        if (is_string($this->visibleOnList)) {
            return Gate::allows($this->visibleOnList, $resource->getModelClass());
        }

        return true;
    }

    /**
     * Determines if the field is visible in the detail.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function isVisibleOnDetail(Resource $resource, Model $model): bool
    {
        if ($this->visibleOnDetail instanceof \Closure) {
            return value($this->visibleOnDetail, $resource, $model);
        }

        if (is_bool($this->visibleOnDetail)) {
            return $this->visibleOnDetail;
        }

        if (is_string($this->visibleOnDetail)) {
            return Gate::allows($this->visibleOnDetail, $model);
        }

        return true;
    }

    /**
     * Determines if the field is visible on create form.
     *
     * @param \Insight\Resources\Resource $resource
     * @return bool
     */
    public function isVisibleOnCreate(Resource $resource): bool
    {
        if ($this->visibleOnCreate instanceof \Closure) {
            return value($this->visibleOnCreate, $resource);
        }

        if (is_bool($this->visibleOnCreate)) {
            return $this->visibleOnCreate;
        }

        if (is_string($this->visibleOnCreate)) {
            return Gate::allows($this->visibleOnCreate, $resource->getModelClass());
        }

        return true;
    }

    /**
     * Determines if the field is visible on update form.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function isVisibleOnUpdate(Resource $resource, Model $model): bool
    {
        if ($this->visibleOnUpdate instanceof \Closure) {
            return value($this->visibleOnUpdate, $resource, $model);
        }

        if (is_bool($this->visibleOnUpdate)) {
            return $this->visibleOnUpdate;
        }

        if (is_string($this->visibleOnUpdate)) {
            return Gate::allows($this->visibleOnUpdate, $model);
        }

        return true;
    }

    /**
     * Set if the field can be visible on the list.
     * Can be callback, bool or gate policy name.
     *
     * @param string|bool|\Closure $visible
     * @return $this
     */
    public function canSeeOnList(string|bool|\Closure $visible): static
    {
        $this->visibleOnList = $visible;

        return $this;
    }

    /**
     * Set if the field can be visible in the detail.
     * Can be callback, bool or gate policy name.
     *
     * @param string|bool|\Closure $visible
     * @return $this
     */
    public function canSeeOnDetail(string|bool|\Closure $visible): static
    {
        $this->visibleOnDetail = $visible;

        return $this;
    }

    /**
     * Set if the field can be visible during creation.
     * Can be callback, bool or gate policy name.
     *
     * @param string|bool|\Closure $visible
     * @return $this
     */
    public function canSeeOnCreate(string|bool|\Closure $visible): static
    {
        $this->visibleOnCreate = $visible;

        return $this;
    }

    /**
     * Set if the field can be visible during update.
     * Can be callback, bool or gate policy name.
     *
     * @param string|bool|\Closure $visible
     * @return $this
     */
    public function canSeeOnUpdate(string|bool|\Closure $visible): static
    {
        $this->visibleOnUpdate = $visible;

        return $this;
    }

    /**
     * Set if the field can be visible during creation and update.
     * Can be callback, bool or gate policy name.
     *
     * @param string|bool|\Closure $visible
     * @return $this
     */
    public function canSeeOnForms(string|bool|\Closure $visible): static
    {
        return $this->canSeeOnCreate($visible)->canSeeOnUpdate($visible);
    }

    /**
     * Set if the field can be visible.
     *
     * @param string|bool|\Closure $visible
     * @return $this
     */
    public function canSee(string|bool|\Closure $visible): static
    {
        return $this
            ->canSeeOnList($visible)
            ->canSeeOnDetail($visible)
            ->canSeeOnForms($visible);
    }

    /**
     * Hides field from list.
     *
     * @return $this
     */
    public function hideFromIndex(): static
    {
        return $this->hideOnList();
    }

    /**
     * Hides field from list.
     *
     * @return $this
     */
    public function hideOnList(): static
    {
        return $this->canSeeOnList(false);
    }

    /**
     * Hides the field on detail.
     *
     * @return $this
     */
    public function hideOnDetail(): static
    {
        return $this->canSeeOnDetail(false);
    }

    /**
     * Hides the field on create form.
     *
     * @return $this
     */
    public function hideOnCreate(): static
    {
        return $this->canSeeOnCreate(false);
    }

    /**
     * Hides the field on update form.
     *
     * @return $this
     */
    public function hideOnUpdate(): static
    {
        return $this->canSeeOnUpdate(false);
    }

    /**
     * Hides the field on forms.
     *
     * @return $this
     */
    public function hideOnForms(): static
    {
        return $this->hideOnCreate()->hideOnUpdate();
    }

    /**
     * Displays the field only on the list.
     *
     * @return $this
     */
    public function onlyOnIndex(): static
    {
        return $this->onlyOnList();
    }

    /**
     * Displays the field only on the list.
     *
     * @return $this
     */
    public function onlyOnList(): static
    {
        return $this->hideOnDetail()->hideOnCreate()->hideOnUpdate();
    }

    /**
     * Displays the field only on detail.
     *
     * @return $this
     */
    public function onlyOnDetail(): static
    {
        return $this->hideOnList()->hideOnCreate()->hideOnUpdate();
    }

    /**
     * Displays the field only on create form.
     *
     * @return $this
     */
    public function onlyOnCreate(): static
    {
        return $this->hideOnList()->hideOnDetail()->hideOnUpdate();
    }

    /**
     * Displays the field only on update form.
     *
     * @return $this
     */
    public function onlyOnUpdate(): static
    {
        return $this->hideOnList()->hideOnDetail()->hideOnCreate();
    }

    /**
     * Displays the field only on forms.
     *
     * @return $this
     */
    public function onlyOnForms(): static
    {
        return $this->hideOnList()->hideOnDetail();
    }
}
