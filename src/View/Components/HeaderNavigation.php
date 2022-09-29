<?php


namespace Insight\View\Components;


use Insight\Inertia\View\Component;
use Insight\View\Models\Navigation;

class HeaderNavigation extends Component
{
    /**
     * The navigation displayed in header.
     *
     * @var \Insight\View\Models\Navigation|null
     */
    public ?Navigation $navigation = null;

    /**
     * Set the navigation.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return $this
     */
    public function withNavigation(Navigation $navigation): static
    {
        $this->navigation = $navigation;

        return $this;
    }
}
