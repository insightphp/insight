<?php


namespace Insight\Tables\View\Components;


use Insight\Inertia\View\Component;

class Row extends Component
{
    /**
     * List of cells for the row.
     *
     * @var array
     */
    public array $cells = [];

    /**
     * The identifier used to differentiate the row.
     * The identifier is also used in bulk selection.
     *
     * @var string|int|null
     */
    public string|int|null $id = null;

    /**
     * Set the identifier of the row.
     *
     * @param string|int|null $id
     * @return $this
     */
    public function id(string|int|null $id): static
    {
        $this->id = $id;

        return $this;
    }
}
