<?php


namespace Insight\Forms\Fields;


use Insight\Forms\Field;
use Insight\Forms\ViewComponents\Checkbox;
use Insight\Inertia\ViewComponent;

class Boolean extends Field
{
    public function __construct(
        ?string $label = null
    ) {
        $this->label($label);
    }

    /**
     * Sets the checkbox label.
     *
     * @param string|null $label
     * @return $this
     */
    public function label(?string $label): static
    {
        return $this->apply(fn (Checkbox $checkbox) => $checkbox->withLabel($label));
    }

    public function getEmptyValue(): mixed
    {
        return false;
    }

    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(Checkbox::make());
    }
}
