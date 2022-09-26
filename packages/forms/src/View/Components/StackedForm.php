<?php


namespace Insight\Forms\View\Components;


use Insight\Forms\Form;
use Insight\Forms\FormControl;
use Insight\Inertia\View\Component;

class StackedForm extends Component
{
    /**
     * The form controls of the form.
     *
     * @var array
     */
    public array $items = [];

    /**
     * Adds control to the form.
     *
     * @param \Insight\Forms\FormControl $control
     * @return $this
     */
    public function addControl(FormControl $control): static
    {
        $this->items[] = [
            'label' => $control->getLabel(),
            'name' => $control->name(),
            'hint' => $control->getHint(),
            'isRequired' => $control->isRequired(),
            'fieldView' => $control->field()->toView(),
        ];

        return $this;
    }

    /**
     * Creates new stacked form.
     *
     * @param \Insight\Forms\Form $form
     * @return \Insight\Forms\View\Components\StackedForm
     */
    public static function for(Form $form): StackedForm
    {
        $stackedForm = static::make();

        $form->controls()->each(fn (FormControl $control) => $stackedForm->addControl($control));

        return $stackedForm;
    }
}
