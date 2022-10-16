<?php


namespace Insight\Forms\View\Components;


use Insight\Forms\Form as FormBlueprint;
use Insight\Forms\FormControl;

class StackedForm extends Form
{
    /**
     * List of form controls.
     *
     * @var array
     */
    public array $controls = [];

    public function __construct(
        FormBlueprint $form
    )
    {
        parent::__construct($form);

        $this->form->controls()->each(function (FormControl $control) {
            $this->controls[] = StackedFormControl::make([
                'name' => $control->name(),
                'label' => $control->getLabel(),
                'control' => $control->field()->resolveViewComponent(),
                'isRequired' => $control->isRequired(),
            ]);
        });
    }
}
