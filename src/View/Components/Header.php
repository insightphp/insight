<?php


namespace Insight\View\Components;


use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;
use Insight\View\Models\Navigation;
use Insight\View\Models\User;

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

    /**
     * The navigation displayed under name.
     *
     * @var \Insight\View\Models\Navigation|null
     */
    public ?Navigation $userNavigation;

    /**
     * The Insight user.
     *
     * @var \Insight\View\Models\User|null
     */
    public ?User $user;

    #[Computed(name: 'showSearch')]
    public function shouldShowSearch(): bool
    {
        // TODO: Spotlight feature

        return false;
    }
}
