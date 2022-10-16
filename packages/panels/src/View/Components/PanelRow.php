<?php


namespace Insight\Panels\View\Components;


use Insight\Inertia\View\Component;

class PanelRow extends Component
{
    /**
     * The title of the panel row.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * The value of the panel row.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $value = null;
}
