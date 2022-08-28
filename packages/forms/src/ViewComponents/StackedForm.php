<?php


namespace Insight\Forms\ViewComponents;


use Insight\Forms\Form;
use Insight\Forms\FormControl;
use Insight\Inertia\ViewComponent;

class StackedForm extends ViewComponent
{
    /**
     * The form controls of the form.
     *
     * @var array
     */
    public array $items = [];

    /**
     * The initial value of the form.
     *
     * @var array
     */
    public array $initialValue = [];

    /**
     * The location where the form should be submitted.
     *
     * @var string|null
     */
    public ?string $action = null;

    /**
     * The method used to submit the form.
     *
     * @var string|null
     */
    public ?string $method = null;

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
     * @return \Insight\Forms\ViewComponents\StackedForm
     */
    public static function for(Form $form): StackedForm
    {
        $stackedForm = static::make();

        $form->controls()->each(fn (FormControl $control) => $stackedForm->addControl($control));

        $stackedForm->initialValue = $form->getInertiaFormValue();
        $stackedForm->method = $form->getMethod();
        $stackedForm->action = $form->getAction();

        return $stackedForm;
    }
}
