<?php


namespace Insight\Forms\Fields;


use Insight\Elements\TextInput;
use Insight\Forms\Field;
use Insight\Inertia\ViewComponent;

class Text extends Field
{
    /**
     * Set the text type to password.
     *
     * @return $this
     */
    public function secret(): static
    {
        return $this->apply(fn (TextInput $input) => $input->secret());
    }

    /**
     * Set the placeholder of the input.
     *
     * @param string|null $placeholder
     * @return $this
     */
    public function placeholder(?string $placeholder): static
    {
        return $this->apply(fn (TextInput $input) => $input->placeholder($placeholder));
    }

    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(TextInput::make());
    }
}
