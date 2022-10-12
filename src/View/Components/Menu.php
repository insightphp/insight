<?php


namespace Insight\View\Components;


use Insight\Inertia\View\Component;
use Insight\View\Models\Navigation;

class Menu extends Component
{
    /**
     * The navigation in the menu.
     *
     * @var \Insight\View\Models\Navigation
     */
    public Navigation $navigation;

    /**
     * Custom toggle for the menu.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $toggle = null;

    /**
     * Set custom toggle for the menu.
     *
     * @param \Insight\Inertia\View\Component $component
     * @return $this
     */
    public function withToggle(Component $component): static
    {
        $this->toggle = $component;

        return $this;
    }

    /**
     * Create menu for given navigation.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return static
     */
    public static function withNavigation(Navigation $navigation): static
    {
        return static::make(['navigation' => $navigation]);
    }
}
