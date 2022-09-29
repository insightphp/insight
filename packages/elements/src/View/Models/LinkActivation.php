<?php


namespace Insight\Elements\View\Models;


use Insight\Inertia\Support\ListOf;
use Insight\Inertia\View\Model;

class LinkActivation extends Model
{
    /**
     * List of routes when the link should be activated.
     *
     * @var array<\Insight\Elements\View\Models\LinkActivatedOnRoute>
     */
    #[ListOf(LinkActivatedOnRoute::class)]
    public array $activatedOnRoutes = [];

    /**
     * List of locations when the link should be activated.
     *
     * @var array
     */
    public array $activatedOnLocations = [];

    /**
     * Add location when the link should be considered as active.
     *
     * @param string $location
     * @return $this
     */
    public function onLocation(string $location): static
    {
        $this->activatedOnLocations[] = $location;

        return $this;
    }

    /**
     * Add route when the link is considered as active.
     *
     * @param string|\Insight\Elements\View\Models\LinkActivatedOnRoute $routeName
     * @param array $params
     * @return $this
     */
    public function onRoute(string|LinkActivatedOnRoute $routeName, array $params = []): static
    {
        if ($routeName instanceof LinkActivatedOnRoute) {
            $this->activatedOnRoutes[] = $routeName;
        } else {
            $this->activatedOnRoutes[] = LinkActivatedOnRoute::make([
                'route' => $routeName,
                'params' => $params,
            ]);
        }

        return $this;
    }
}
