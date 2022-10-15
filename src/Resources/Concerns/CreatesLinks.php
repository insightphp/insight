<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Link;
use Insight\Resources\ResourceLinks;
use Insight\View\Models\NavigationItem;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CreatesLinks
{
    /**
     * Determine if the resources should be visible in navigation.
     *
     * @var bool
     */
    protected bool $shouldShowInNavigation = true;

    /**
     * Determine if the resource should be displayed in navigation.
     *
     * @return bool
     */
    public function shouldShowInNavigation(): bool
    {
        return $this->shouldShowInNavigation;
    }

    /**
     * Retrieve link generator for the resources.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return \Insight\Resources\ResourceLinks
     */
    public function createLinks(?Model $model = null): ResourceLinks
    {
        return new ResourceLinks($this, $model);
    }

    /**
     * Create navigation item for the Resource.
     *
     * @return \Insight\View\Models\NavigationItem
     */
    public function createNavigationItem(): NavigationItem
    {
        $links = $this->createLinks();

        $link = Link::make([
            'title' => $this->getDisplayPluralName(),
            'location' => $links->index(),
        ]);

        foreach ($links->getActivationRoutes() as $routeName => $params) {
            $link->activatedOnRoute($routeName, $params);
        }

        return NavigationItem::for($link);
    }

}
