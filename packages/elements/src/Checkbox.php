<?php


namespace Insight\Elements;


use Insight\Inertia\ViewComponent;

class Checkbox extends ViewComponent
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
