<?php


namespace Insight\Elements;


use Insight\Inertia\ViewComponent;

class TextArea extends ViewComponent
{
    /**
     * The row count of the text area.
     *
     * @var int|null
     */
    public ?int $rows = null;

    /**
     * The placeholder of the text area.
     *
     * @var string|null
     */
    public ?string $placeholder = null;

    /**
     * Set the row count on the text area.
     *
     * @param int|null $rows
     * @return $this
     */
    public function rows(?int $rows): static
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Set the placeholder of the text area.
     *
     * @param string|null $placeholder
     * @return $this
     */
    public function placeholder(?string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }
}
