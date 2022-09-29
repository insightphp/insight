<?php


namespace Insight\View\Models;


use Insight\Elements\View\Components\Link;
use Insight\Inertia\View\Model;

class NavigationItem extends Model
{
    /**
     * Link for navigation item.
     *
     * @var \Insight\Elements\View\Components\Link
     */
    public Link $link;

    /**
     * The child navigation for this navigation item.
     *
     * @var \Insight\View\Models\Navigation|null
     */
    public ?Navigation $childNavigation = null;

    /**
     * Set the child navigation on this item.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return $this
     */
    public function setChildNavigation(Navigation $navigation): static
    {
        $this->childNavigation = $navigation;

        return $this;
    }

    /**
     * Creates navigation item for given link.
     *
     * @param \Insight\Elements\View\Components\Link $link
     * @return static
     */
    public static function for(Link $link): static
    {
        return static::make([
            'link' => $link,
        ]);
    }
}
