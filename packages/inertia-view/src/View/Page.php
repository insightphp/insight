<?php


namespace Insight\Inertia\View;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Inertia\ResponseFactory;
use Insight\Inertia\Exceptions\ViewException;
use Insight\Inertia\Support\Computed;

class Page extends Model implements Responsable
{
    /**
     * The underlaying component for the page.
     *
     * @var string|null
     */
    protected ?string $page = null;

    /**
     * Custom attributes of the page.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Page layouts.
     *
     * @var \Insight\Inertia\View\LayoutStack|null
     */
    protected ?LayoutStack $layouts = null;

    /**
     * The dialogs available on the page.
     *
     * @var array
     */
    protected array $dialogs = [];

    /**
     * Add dialog to the page.
     *
     * @param string $id
     * @param \Closure $dialogFactory
     * @return $this
     */
    public function dialog(string $id, \Closure $dialogFactory): static
    {
        $this->dialogs[$id] = $dialogFactory;

        return $this;
    }

    /**
     * Add attribute to the page.
     *
     * @param string|array $key
     * @param mixed|null $value
     * @return $this
     */
    public function with(string|array $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->attributes = array_merge($this->attributes, $key);
        } else if ($key instanceof Arrayable) {
            $this->attributes = array_merge($this->attributes, $key->toArray());
        } else {
            Arr::set($this->attributes, $key, $value);
        }

        return $this;
    }

    /**
     * Set page component for the page.
     *
     * @param string $component
     * @return $this
     */
    public function usePage(string $component): static
    {
        $this->page = $component;

        return $this;
    }

    /**
     * Set the layout component for the page.
     *
     * @param \Insight\Inertia\View\Component ...$layout
     * @return $this
     */
    public function layout(Component ...$layout): static
    {
        foreach ($layout as $component) {
            $this->getLayoutStack()->add($component);
        }

        return $this;
    }

    /**
     * Retrieve the layout stack for the page.
     *
     * @return \Insight\Inertia\View\LayoutStack
     */
    public function getLayoutStack(): LayoutStack
    {
        if ($this->layouts === null) {
            $this->layouts = new LayoutStack();
        }

        return $this->layouts;
    }

    /**
     * Retrieve layout for the page.
     *
     * @return array|null
     */
    #[Computed(name: '_layouts')]
    public function getLayouts(): ?array
    {
        $stack = $this->getLayoutStack();

        if ($stack->isEmpty()) {
            return null;
        }

        return $stack->getLayouts();
    }

    #[Computed(name: '_dialog')]
    public function getDialog(Request $request): ?Component
    {
        $dialog = $this->resolveDialogFromRequest($request);

        $data = $this->resolveDialogDataFromRequest($request);

        if (is_string($dialog)) {
            $factory = $this->dialogs[$dialog];

            return value($factory, $data);
        }

        return null;
    }

    /**
     * Resolve the page component.
     *
     * @return string
     */
    public function resolvePageComponent(): string
    {
        if (is_null($this->page)) {
            throw new ViewException("The component for the page [".static::class."] is not defined.");
        }

        return $this->page;
    }

    /**
     * Resolve dialog from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function resolveDialogFromRequest(Request $request): ?string
    {
        $sessionDialog = Session::get('showInsightDialog');

        if (is_array($sessionDialog)) {
            $dialog = Arr::get($sessionDialog, 'dialog');
        } else {
            $dialog = $request->input('dialog');
        }

        if (is_string($dialog) && Arr::has($this->dialogs, $dialog)) {
            return $dialog;
        }

        return null;
    }

    /**
     * Resolve dialog data from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function resolveDialogDataFromRequest(Request $request): array
    {
        $sessionDialog = Session::get('showInsightDialog');

        if (is_array($sessionDialog)) {
            $params = Arr::get($sessionDialog, 'params');

            if (is_array($params)) {
                return $params;
            }
        }

        return [];
    }

    /**
     * Retrieve response data which should be sent to Inertia.
     *
     * @return array
     */
    public function resolvePageData(): array
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), $this->prepareForInertia($this->attributes));
    }

    public function toResponse($request)
    {
        return app(ResponseFactory::class)
            ->render($this->resolvePageComponent(), $this->resolvePageData())
            ->toResponse($request);
    }

    /**
     * Creates new page using given component and attributes.
     *
     * @param string $component
     * @param array $attributes
     * @return static
     */
    public static function render(string $component, array $attributes = []): static
    {
        return static::make($attributes)->usePage($component);
    }

    /**
     * Creates new page instance.
     *
     * @param array $attributes
     * @return static
     */
    public static function make(array $attributes = []): static
    {
        return parent::make(Arr::except($attributes, ['page', 'attributes', 'layout']));
    }
}
