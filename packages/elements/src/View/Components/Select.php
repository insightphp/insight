<?php


namespace Insight\Elements\View\Components;


use Insight\Elements\View\Option;
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
     * @param \Insight\Elements\View\Option $option
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
