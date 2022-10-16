<?php


namespace Insight\Forms\View\Components;


use Insight\Inertia\View\Component;

class StackedFormControl extends Component
{
    /**
     * The control name.
     *
     * @var string
     */
    public string $name;

    /**
     * The label of the control.
     *
     * @var string
     */
    public string $label;

    /**
     * Displays required asterisk next to the control label.
     *
     * @var bool
     */
    public bool $isRequired = false;

    /**
     * The actual control of the form.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public Component $control;
}
