<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Insight\Forms\Form;

class Updater
{
    public function __construct(
        protected Resource $resource,
        protected Model $model
    ) {}

    /**
     * Update value from array.
     *
     * @param array $formValue
     * @return void
     */
    public function updateFromArray(array $formValue): void
    {
        $pendingSetters = $this->resource->getFieldCollection()->filter(function (Field $field) {
            return $field->hasFormField() && $field->isVisibleOnUpdate($this->resource, $this->model);
        })->map(function (Field $field) use ($formValue) {
            $value = Arr::get($formValue, $field->getFormControlName());

            $hydrated = $field->hydrateFormValue($this->resource, $value);

            return $field->setValue($this->resource, $this->model, $hydrated);
        })->filter(fn ($setter) => $setter instanceof PendingValue)->sortBy(function (PendingValue $pendingValue) {
            return $pendingValue->getPriority();
        });

        if (method_exists($this->resource, 'beforeUpdate')) {
            $this->resource->beforeUpdate($this->model, $formValue);
        }

        if (method_exists($this->resource, 'beforeSave')) {
            $this->resource->beforeSave($this->model, $formValue);
        }

        $this->model->save();

        if (method_exists($this->resource, 'afterUpdate')) {
            $this->resource->afterUpdate($this->model, $formValue);
        }

        if (method_exists($this->resource, 'afterSave')) {
            $this->resource->afterSave($this->model, $formValue);
        }

        $pendingSetters->each(function (PendingValue $pendingValue) {
            $pendingValue->savePendingValue();
        });
    }

    /**
     * Update resource from form.
     *
     * @param \Insight\Forms\Form $form
     * @return void
     */
    public function updateFromForm(Form $form): void
    {
        $this->updateFromArray($form->value());
    }
}
