<?php


namespace Insight\Elements\View\Components;


use Insight\Inertia\View\Component;

class Text extends Component
{
    /**
     * The tag used to render the text.
     *
     * @var string
     */
    public string $as = 'span';

    /**
     * The text value.
     *
     * @var string|null
     */
    public ?string $value = null;

    /**
     * Flag if the text should be rendered as HTML.
     *
     * @var bool
     */
    public bool $asHtml = false;

    /**
     * Render the text as HTML.
     *
     * @param bool $asHtml
     * @return $this
     */
    public function asHtml(bool $asHtml = true): static
    {
        $this->asHtml = $asHtml;

        return $this;
    }

    /**
     * Set the value of the text.
     *
     * @param string|null $value
     * @return $this
     */
    public function value(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the tag used to render the text.
     *
     * @param string $tag
     * @return $this
     */
    public function as(string $tag): static
    {
        $this->as = $tag;

        return $this;
    }

    /**
     * Render text as h1.
     *
     * @return $this
     */
    public function h1(): static
    {
        return $this->as('h1');
    }

    /**
     * Render text as h2.
     *
     * @return $this
     */
    public function h2(): static
    {
        return $this->as('h2');
    }

    /**
     * Render text as h3.
     *
     * @return $this
     */
    public function h3(): static
    {
        return $this->as('h3');
    }

    /**
     * Render text as h4.
     *
     * @return $this
     */
    public function h4(): static
    {
        return $this->as('h4');
    }

    /**
     * Render text as h5.
     *
     * @return $this
     */
    public function h5(): static
    {
        return $this->as('h5');
    }

    /**
     * Render text as h6.
     *
     * @return $this
     */
    public function h6(): static
    {
        return $this->as('h6');
    }

    /**
     * Render text as span.
     *
     * @return $this
     */
    public function span(): static
    {
        return $this->as('span');
    }

    /**
     * Create new Text component with given text.
     *
     * @param string|null $value
     * @return static
     */
    public static function of(?string $value): static
    {
        return static::make(['value' => $value]);
    }
}
