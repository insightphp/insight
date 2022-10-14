<?php


namespace Insight\Elements\View\Components;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;
use Insight\View\Components\Heroicon;

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
     * The data for the link.
     *
     * @var array|null
     */
    public ?array $data = null;

    /**
     * Marks link as external, which means it will always be rendered
     * with <a> tag and all Inertia features will be disabled.
     * The link will be submitted in standard way and not intercepted by Inertia.
     *
     * @var bool
     */
    public bool $external = false;

    /**
     * List of callbacks which should determine if the link is considered active.
     *
     * @var array<Closure>
     */
    protected array $activatedWhen = [];

    /**
     * The content of the link.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $content = null;

    /**
     * Display link as button.
     *
     * @var bool
     */
    public bool $asButton = false;

    /**
     * The button look.
     *
     * @var string
     */
    public string $buttonType = 'primary';

    /**
     * Determine if the scroll position should be preserved.
     *
     * @var bool
     */
    public bool $preserveScroll = false;

    public function preserveScroll(bool $preserve = true): static
    {
        $this->preserveScroll = $preserve;

        return $this;
    }

    /**
     * Display link as button.
     *
     * @param string $type
     * @param string|null $icon
     * @param int $iconSize
     * @param string $iconStyle
     * @return $this
     */
    public function asButton(string $type = 'primary', ?string $icon = null, int $iconSize = 24, string $iconStyle = 'outline'): static
    {
        $this->asButton = true;
        $this->buttonType = $type;

        $content = [];
        if ($icon) {
            $content[] = Heroicon::for($icon, $iconSize, $iconStyle);
        }

        $content[] = Text::of($this->title);

        return $this->withContent(Stack::of($content)->gap(2));
    }

    public function withData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set custom content for the link.
     *
     * @param \Insight\Inertia\View\Component $component
     * @return $this
     */
    public function withContent(Component $component): static
    {
        $this->content = $component;

        return $this;
    }

    /**
     * Set custom content wrapped in Pressable.
     *
     * @param \Insight\Inertia\View\Component $component
     * @return $this
     */
    public function withPressableContent(Component $component): static
    {
        $this->content = Pressable::for($component);

        return $this;
    }

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

        if (is_string($this->method)) {
            $this->method = strtoupper($this->method);
        }

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
     * Add custom callback which should determine if link is active.
     *
     * @param \Closure $when
     * @return $this
     */
    public function activatedWhen(Closure $when): static
    {
        $this->activatedWhen[] = $when;

        return $this;
    }

    /**
     * Mark link as active on given route.
     *
     * @param string $route
     * @param array $params
     * @return $this
     */
    public function activatedOnRoute(string $route, array $params = []): static
    {
        return $this->activatedWhen(function (Request $request) use ($route, $params) {
            return empty($params) ? $request->routeIs($route) : Str::startsWith($request->path(), ltrim(route($route, $params, false), '/'));
        });
    }

    /**
     * Mark link as active on given location.
     *
     * @param string $location
     * @return $this
     */
    public function activatedOnLocation(string $location): static
    {
        return $this->activatedWhen(function (Request $request) use ($location) {
            if (Str::startsWith($location, 'http')) {
                return $request->url() === $location;
            }

            return $request->path() === ltrim($location, '/');
        });
    }

    /**
     * Determine if the link is active for current request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    #[Computed]
    public function isActive(Request $request): bool
    {
        return collect($this->activatedWhen)
            ->some(fn (Closure $activated) => call_user_func($activated, $request));
    }

    /**
     * Creates link for given route.
     *
     * @param string $title
     * @param string $route
     * @param array $params
     * @param bool $absolute
     * @return static
     */
    public static function toRoute(string $title, string $route, array $params = [], bool $absolute = true): static
    {
        return static::make(['title' => $title, 'location' => route($route, $params, $absolute)])
            ->activatedOnRoute($route, $params);
    }

    /**
     * Creates link to given location.
     *
     * @param string $title
     * @param string $location
     * @param bool $external
     * @return \Insight\Elements\View\Components\Link
     */
    public static function toLocation(string $title, string $location, bool $external = false): static
    {
        return static::make(['title' => $title, 'location' => $location, 'external' => $external])
            ->activatedOnLocation($location);
    }

    /**
     * Creates link to dialog.
     *
     * @param string $title
     * @param string $dialog
     * @param array $data
     * @return static
     */
    public static function toDialog(string $title, string $dialog, array $data = []): static
    {
        return static::toLocation($title, request()->fullUrl())
            ->withData(array_merge(['dialog' => $dialog], $data))
            ->method('POST')
            ->as('button')
            ->preserveScroll();
    }

    /**
     * Creates link to nowhere.
     *
     * @param string $title
     * @return $this
     */
    public static function toNowhere(string $title): static
    {
        return static::make(['title' => $title, 'location' => '#']);
    }
}
