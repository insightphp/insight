<?php


namespace Insight\Resources\Fields\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Component;
use Insight\Resources\Resource;

trait DisplaysInForms
{
    /**
     * Custom factory for form field.
     *
     * @var \Closure|null
     */
    protected ?\Closure $createFormFieldUsing = null;

    /**
     * Determine if the field is displayable in the form.
     *
     * @return bool
     */
    public function hasFormField(): bool
    {
        return method_exists($this, 'resolveFormField');
    }

    /**
     * Creates new form field.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return \Insight\Inertia\View\Component|null
     */
    public function createFormField(Resource $resource, ?Model $model): ?Component
    {
        if ($this->createFormFieldUsing instanceof \Closure) {
            return value($this->createFormFieldUsing, $resource, $model, $this);
        }

        if ($this->hasFormField()) {
            return $this->resolveFormField($resource, $model);
        }

        return null;
    }

    /**
     * Set custom factory for form field.
     *
     * @param \Closure $factory
     * @return $this
     */
    public function createFormFieldUsing(\Closure $factory): static
    {
        $this->createFormFieldUsing = $factory;

        return $this;
    }
}
