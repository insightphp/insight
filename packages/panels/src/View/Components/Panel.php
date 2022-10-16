<?php


namespace Insight\Panels\View\Components;


use Insight\Inertia\Support\ListOf;
use Insight\Inertia\View\Component;

class Panel extends Component
{
    /**
     * The title of the panel.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * The subtitle of the panel.
     *
     * @var string|null
     */
    public ?string $subtitle = null;

    /**
     * The actions on the panel.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $actions = null;

    /**
     * The panel items.
     *
     * @var array<Component>
     */
    #[ListOf(Component::class)]
    public array $items = [];
}
