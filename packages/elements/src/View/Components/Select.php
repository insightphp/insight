<?php


namespace Insight\Elements\View\Components;


use Insight\Elements\View\Option;
use Insight\Inertia\Support\ListOf;
use Insight\Inertia\View\Component;

class Select extends Component
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
