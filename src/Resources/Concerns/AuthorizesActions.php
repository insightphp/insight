<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin \Insight\Resources\Resource
 */
trait AuthorizesActions
{
    /**
     * Default authorization when Policy is not defined.
     *
     * @var bool
     */
    protected \Closure|bool $authorizeByDefault = true;

    /**
     * Set custom authorization callback when Policy is not defined.
     *
     * @param bool|\Closure $authorize
     * @return $this
     */
    public function authorizeByDefault(bool|\Closure $authorize = true): static
    {
        $this->authorizeByDefault = $authorize;

        return $this;
    }

    /**
     * Determine if user is authorized to list resources.
     *
     * @return bool
     */
    public function canViewAnyResources(): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('viewAny', $this->getModelClass());
        }

        return value($this->authorizeByDefault, 'viewAny', $this);
    }

    /**
     * Determine if user is authorized to view resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function canViewResource(Model $model): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('view', $model);
        }

        return value($this->authorizeByDefault, 'view', $this, $model);
    }

    /**
     * Determine if user is authorized to create resource.
     *
     * @return bool
     */
    public function canCreateResource(): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('create', $this->getModelClass());
        }

        return value($this->authorizeByDefault, 'create', $this);
    }

    /**
     * Determine if user is authorized to update the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function canUpdateResource(Model $model): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('update', $model);
        }

        return value($this->authorizeByDefault, 'update', $this, $model);
    }

    /**
     * Determine if user is authorized to delete resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function canDeleteResource(Model $model): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('delete', $model);
        }

        return value($this->authorizeByDefault, 'delete', $this, $model);
    }

    /**
     * Determine if user is authorized to force delete resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function canForceDeleteResource(Model $model): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('forceDelete', $model);
        }

        return value($this->authorizeByDefault, 'forceDelete', $this, $model);
    }

    /**
     * Determine if user is authoirzed to restore resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function canRestoreResource(Model $model): bool
    {
        if (Gate::getPolicyFor($this->getModelClass())) {
            return Gate::allows('restore', $model);
        }

        return value($this->authorizeByDefault, 'restore', $this, $model);
    }
}
