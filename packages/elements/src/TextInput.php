<?php


namespace Insight\Elements;


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
     * The step attribute of the text input.
     *
     * @var string|null
     */
    public ?string $step = null;

    /**
     * Set the step attribute of the text input.
     *
     * @param string|null $step
     * @return $this
     */
    public function step(?string $step): static
    {
        $this->step = $step;

        return $this;
    }

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

    /**
     * Set the type of the text input to number.
     *
     * @return $this
     */
    public function number(): static
    {
        return $this->type('number');
    }

    /**
     * Set the type of the text input to  email.
     *
     * @return $this
     */
    public function email(): static
    {
        return $this->type('email');
    }
}
