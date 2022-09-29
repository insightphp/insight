<?php


namespace Insight\Elements\View\Components;


use Insight\Inertia\View\Component;

class Checkbox extends Component
{
    /**
     * The label of the checkbox.
     *
     * @var string|null
     */
    public ?string $label = null;

    /**
     * Set the checkbox label.
     *
     * @param string|null $label
     * @return $this
     */
    public function withLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
