<?php


namespace Insight\View\Components;


use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;

class Header extends Component
{
    /**
     * Navigation shown on the left side.
     *
     * @var \Insight\View\Components\HeaderNavigation|null
     */
    public ?HeaderNavigation $leftNavigation;

    /**
     * Navigation shown on the right side.
     *
     * @var \Insight\View\Components\HeaderNavigation|null
     */
    public ?HeaderNavigation $rightNavigation;

    #[Computed(name: 'showSearch')]
    public function shouldShowSearch(): bool
    {
        return true;
    }
}
