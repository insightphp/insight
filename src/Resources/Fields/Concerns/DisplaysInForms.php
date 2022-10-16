<?php


namespace Insight\Resources\Fields\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Forms\Field;
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
     * @return \Insight\Forms\Field|null
     */
    public function createFormField(Resource $resource, ?Model $model): ?Field
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

    /**
     * Retrieves the form control label.
     *
     * @return string|null
     */
    public function getFormLabel(): ?string
    {
        return $this->getTitle();
    }

    /**
     * Retrieve form control name for the field.
     *
     * @return string
     */
    public function getFormControlName(): string
    {
        return $this->getAttributeName();
    }

    /**
     * Retrieve value for the form.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function getFormValue(Resource $resource, Model $model): mixed
    {
        return $this->getValue($resource, $model);
    }

    /**
     * Hydrates value of the form.
     *
     * @param \Insight\Resources\Resource $resource
     * @param mixed $value
     * @return mixed
     */
    public function hydrateFormValue(Resource $resource, mixed $value): mixed
    {
        return $value;
    }
}
