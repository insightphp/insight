<?php


namespace Insight\View\Layouts;


use Insight\Inertia\View\Component;
use Insight\View\Models\Navigation;

class DrawerLayout extends Component
{
    /**
     * The header component for the layout.
     *
     * @var \Insight\Inertia\View\Component
     */
    public Component $header;

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
