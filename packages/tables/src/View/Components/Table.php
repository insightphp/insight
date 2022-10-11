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
}
