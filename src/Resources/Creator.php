<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Insight\Forms\Form;

class Creator
{
    public function __construct(
        protected Resource $resource
    ) {}

    /**
     * Create model from array value.
     *
     * @param array $formValue
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createFromArray(array $formValue): Model
    {
        $model = $this->resource->newModel();

        $pendingSetters = $this->resource->getFieldCollection()->filter(function (Field $field) {
            return $field->hasFormField() && $field->isVisibleOnCreate($this->resource);
        })->map(function (Field $field) use ($formValue, $model) {
            $value = Arr::get($formValue, $field->getFormControlName());

            $hydrated = $field->hydrateFormValue($this->resource, $value);

            return $field->setValue($this->resource, $model, $hydrated);
        })->filter(fn ($setter) => $setter instanceof PendingValue)->sortBy(function (PendingValue $pendingValue) {
            return $pendingValue->getPriority();
        });

        if (method_exists($this->resource, 'beforeCreate')) {
            $this->resource->beforeCreate($model, $formValue);
        }

        if (method_exists($this->resource, 'beforeSave')) {
            $this->resource->beforeSave($model, $formValue);
        }

        $model->save();

        if (method_exists($this->resource, 'afterCreate')) {
            $this->resource->afterCreate($model, $formValue);
        }

        if (method_exists($this->resource, 'afterSave')) {
            $this->resource->afterSave($model, $formValue);
        }

        $pendingSetters->each(function (PendingValue $pendingValue) {
            $pendingValue->savePendingValue();
        });

        return $model;
    }

    /**
     * Create model from form.
     *
     * @param \Insight\Forms\Form $form
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createFromForm(Form $form): Model
    {
        return $this->createFromArray($form->value());
    }
}
