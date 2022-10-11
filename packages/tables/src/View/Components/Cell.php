<?php


namespace Insight\Tables\View\Components;


use Insight\Inertia\View\Component;

class Cell extends Component
{
    /**
     * Determine if the cell should be rendered as <th> instead of <td>.
     *
     * @var bool
     */
    public bool $asHeader = false;

    /**
     * The value of the cell.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $value = null;

    /**
     * Set cell to be rendered as <th>
     *
     * @return $this
     */
    public function displayAsHeader(): static
    {
        $this->asHeader = true;

        return $this;
    }

    /**
     * Set cell to be rendered as <td>
     *
     * @return $this
     */
    public function displayAsData(): static
    {
        $this->asHeader = false;

        return $this;
    }
}
