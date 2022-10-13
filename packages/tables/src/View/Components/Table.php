<?php


namespace Insight\Tables\View\Components;


use Insight\Inertia\View\Component;

class Table extends Component
{
    /**
     * The header of the table.
     *
     * @var \Insight\Tables\View\Components\Header|null
     */
    public ?Header $header = null;

    /**
     * Rows of the table.
     *
     * @var array
     */
    public array $rows = [];

    /**
     * The footer of the table.
     *
     * @var \Insight\Tables\View\Components\Footer|null
     */
    public ?Footer $footer = null;

    /**
     * Determine if the bulk selection is enabled. To use bulk selection,
     * every row must have valid identifier or DataTable will throw error.
     *
     * @var bool
     */
    public bool $enableBulkSelection = false;

    /**
     * The default table sorting.
     *
     * @var string|null
     */
    public ?string $defaultSortAs = null;

    /**
     * The default sort direction.
     *
     * @var string
     */
    public string $defaultSortDirection = 'desc';

    public function defaultSortAs(string $sortAs, string $direction = 'desc'): static
    {
        $this->defaultSortAs = $sortAs;
        $this->defaultSortDirection = $direction;

        return $this;
    }

    /**
     * Enable or disable bulk selection of rows.
     *
     * @param bool $enableBulkSelection
     * @return $this
     */
    public function withBulkSelection(bool $enableBulkSelection = true): static
    {
        $this->enableBulkSelection = $enableBulkSelection;

        return $this;
    }
}
