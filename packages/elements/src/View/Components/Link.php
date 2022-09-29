<?php


namespace Insight\Elements\View\Components;


use Closure;
use Insight\Elements\View\Models\LinkActivation;
use Insight\Inertia\View\Component;

class Link extends Component
{
    /**
     * The title of the navigation link.
     *
     * @var string
     */
    public string $title;

    /**
     * The location of the navigation link.
     *
     * @var string
     */
    public string $location;

    /**
     * The method used when submitting InertiaLink.
     *
     * @var string|null
     */
    public ?string $method = null;

    /**
     * Determine which tag the InertiaLink will use.
     * When you use method such as POST|PUT|PATCH|DELETE,
     * you should use <button> as tag instead of default <a>.
     *
     * @var string|null
     */
    public ?string $as = null;

    /**
     * Marks link as external, which means it will always be rendered
     * with <a> tag and all Inertia features will be disabled.
     * The link will be submitted in standard way and not intercepted by Inertia.
     *
     * @var bool
     */
    public bool $external = false;

    /**
     * Determine when the Link is in active state.
     *
     * @var \Insight\Elements\View\Models\LinkActivation|null
     */
    public ?LinkActivation $isActive = null;

    /**
     * Set the link title.
     *
     * @param string $title
     * @return $this
     */
    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the link destination.
     *
     * @param string $location
     * @return $this
     */
    public function location(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Set the method for Inertia Link.
     *
     * @param string|null $method
     * @return $this
     */
    public function method(?string $method): static
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set the element tag of Inertia Link.
     *
     * @param string $tag
     * @return $this
     */
    public function as(string $tag): static
    {
        $this->as = $tag;

        return $this;
    }

    /**
     * Mark the link as external.
     *
     * @param bool $external
     * @return $this
     */
    public function external(bool $external = true): static
    {
        $this->external = $external;

        return $this;
    }

    /**
     * Set when the link is in active state.
     *
     * @param \Insight\Elements\View\Models\LinkActivation $isActive
     * @return $this
     */
    public function isActiveWhen(LinkActivation $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Retrieve when the link is in active state.
     *
     * @return \Insight\Elements\View\Models\LinkActivation|null
     */
    public function getActiveWhen(): ?LinkActivation
    {
        return $this->isActive;
    }

    /**
     * Creates link for given route.
     *
     * @param string $title
     * @param string $route
     * @param array $params
     * @param \Closure|null $configureActivation
     * @param bool $absolute
     * @return static
     */
    public static function toRoute(string $title, string $route, array $params = [], ?Closure $configureActivation = null, bool $absolute = true): static
    {
        $activated = LinkActivation::make()->onRoute($route, $params);
        if ($configureActivation instanceof Closure) {
            call_user_func($configureActivation, $activated);
        }

        return static::make(['title' => $title, 'location' => route($route, $params, $absolute)])
            ->isActiveWhen($activated);
    }

    /**
     * Creates link to given location.
     *
     * @param string $title
     * @param string $location
     * @param \Closure|null $configureActivation
     * @param bool $external
     * @return \Insight\Elements\View\Components\Link
     */
    public function toLocation(string $title, string $location, ?Closure $configureActivation = null, bool $external = false): static
    {
        $activated = LinkActivation::make()->onLocation($location);
        if ($configureActivation instanceof Closure) {
            call_user_func($configureActivation, $activated);
        }

        return static::make(['title' => $title, 'location' => $location])
            ->isActiveWhen($activated);
    }

    /**
     * Creates link to nowhere.
     *
     * @param string $title
     * @return $this
     */
    public function toNowhere(string $title): static
    {
        return static::make(['title' => $title, 'location' => '#']);
    }
}
