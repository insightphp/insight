<?php


namespace Insight\Forms\Fields;


use Insight\Elements\View\Components\Checkbox;
use Insight\Forms\Field;
use Insight\Inertia\ViewComponent;

/**
 * @deprecated
 */
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
