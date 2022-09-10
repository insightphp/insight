<?php


namespace Insight\Forms\ViewComponents;


use Insight\Forms\SelectOption;
use Insight\Inertia\Support\ListOf;
use Insight\Inertia\ViewComponent;

class Select extends ViewComponent
{
    /**
     * Select options.
     *
     * @var array
     */
    #[ListOf(SelectOption::class)]
    public array $options = [];

    /**
     * Adds option to the select.
     *
     * @param \Insight\Forms\SelectOption $option
     * @return $this
     */
    public function option(SelectOption $option): static
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
