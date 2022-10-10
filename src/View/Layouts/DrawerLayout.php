<?php


namespace Insight\View\Layouts;


use Insight\Inertia\View\Component;
use Insight\View\Components\Header;
use Insight\View\Models\Navigation;

class DrawerLayout extends Component
{
    /**
     * The header of the layout.
     *
     * @var \Insight\View\Components\Header
     */
    public Header $header;

    /**
     * The main navigation in the drawer.
     *
     * @var \Insight\View\Models\Navigation|null
     */
    public ?Navigation $navigation = null;

    /**
     * Set the navigation used in the drawer.
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
