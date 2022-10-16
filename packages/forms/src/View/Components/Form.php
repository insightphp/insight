<?php


namespace Insight\Forms\View\Components;


use Insight\Forms\Form as FormBlueprint;
use Insight\Inertia\View\Component;

abstract class Form extends Component
{
    /**
     * The value of the form.
     *
     * @var array
     */
    public array $value = [];

    /**
     * The method used to submit the form.
     *
     * @var string
     */
    public string $method = 'POST';

    /**
     * The action where the form should be submited.
     *
     * @var string|null
     */
    public ?string $action = null;

    public function __construct(
        protected FormBlueprint $form
    )
    {
        $this->action = $this->form->getAction();
        $this->method = $this->form->getMethod();
        $this->value = $this->form->getInertiaFormValue();
    }
}
