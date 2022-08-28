<?php


namespace Insight\Forms\ViewComponents;


use Insight\Inertia\ViewComponent;

class TextInput extends ViewComponent
{
    /**
     * The type of the text input.
     *
     * @var string
     */
    public string $type = 'text';

    /**
     * The placeholder of the input.
     *
     * @var string|null
     */
    public ?string $placeholder = null;

    /**
     * Set the type of the input.
     *
     * @param string $type
     * @return $this
     */
    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the placeholder of the input.
     *
     * @param string|null $placeholder
     * @return $this
     */
    public function placeholder(?string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Set the password type on the input.
     *
     * @return $this
     */
    public function secret(): static
    {
        return $this->type('password');
    }
}
