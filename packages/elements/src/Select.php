<?php


namespace Insight\Elements;


use Insight\Inertia\Support\ListOf;
use Insight\Inertia\ViewComponent;

class Select extends ViewComponent
{
    /**
     * Select options.
     *
     * @var array
     */
    #[ListOf(Option::class)]
    public array $options = [];

    /**
     * Adds option to the select.
     *
     * @param \Insight\Elements\Option $option
     * @return $this
     */
    public function option(Option $option): static
    {
        $this->options[] = $option;

        return $this;
    }

    /**
     * Clears all select options.
     *
     * @return void
     */
    public function clearOptions(): void
    {
        $this->options = [];
    }
}
