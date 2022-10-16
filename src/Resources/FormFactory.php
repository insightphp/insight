<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Insight\Forms\Form;
use Insight\Forms\FormControl;

class FormFactory
{
    public function __construct(
        protected Request $request,
        protected Resource $resource,
        protected ?Model $model = null
    ) {}

    /**
     * Determine if building form for editing.
     *
     * @return bool
     */
    protected function isEdit(): bool
    {
        return $this->model != null;
    }

    /**
     * Retrieve fields for form.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getFields(): Collection
    {
        return $this->resource->getFieldCollection()->filter(function (Field $field) {
            if (! $field->hasFormField()) {
                return false;
            }

            if ($this->isEdit()) {
                return $field->isVisibleOnUpdate($this->resource, $this->model);
            }

            return $field->isVisibleOnCreate($this->resource);
        });
    }

    public function createForm(): Form
    {
        $links = $this->resource->createLinks($this->model);

        $form = (new Form())
            ->action($this->isEdit() ? $links->update() : $links->create())
            ->method($this->isEdit() ? 'PATCH' : 'POST');

        $this->getFields()->each(function (Field $field) use ($form) {
            $formField = $field->createFormField($this->resource, $this->model);

            $control = (new FormControl())
                ->withField($formField)
                ->label($field->getFormLabel())
                ->withName($field->getFormControlName())
                ->rules($this->isEdit() ? $field->getUpdateRules() : $field->getCreationRules());

            $form->control($control);

            if ($this->isEdit()) {
                $form->set($field->getFormControlName(), $field->getFormValue($this->resource, $this->model));
            }
        });

        return $form;
    }
}
