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
     * Alignment of the value.
     *
     * @var string
     */
    public string $align = 'left';

    /**
     * Set the value alignment.
     *
     * @param string $align
     * @return $this
     */
    public function align(string $align): static
    {
        $this->align = $align;

        return $this;
    }

    /**
     * Set the cell alignment to the left.
     *
     * @return $this
     */
    public function left(): static
    {
        return $this->align('left');
    }

    /**
     * Set the cell alignment to the right.
     *
     * @return $this
     */
    public function right(): static
    {
        return $this->align('right');
    }

    /**
     * Set the cell alignment to center.
     *
     * @return $this
     */
    public function center(): static
    {
        return $this->align('center');
    }

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
