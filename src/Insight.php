<?php


namespace Insight;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Insight\Inertia\View\Component;
use Insight\Inertia\View\LayoutStack;
use Insight\Resources\Resource;
use Insight\View\Pages\InsightPage;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Insight
{
    /**
     * Global layouts applied on the Insight pages.
     *
     * @var \Insight\Inertia\View\LayoutStack
     */
    protected LayoutStack $layouts;

    /**
     * List of registered resources.
     *
     * @var array<string, Resource>
     */
    protected array $resources = [];

    /**
     * Custom callback to resolve resource from request.
     *
     * @var \Closure|null
     */
    protected ?Closure $resolveResourceFromRequestUsing = null;

    public function __construct()
    {
        $this->layouts = new LayoutStack();
    }

    /**
     * Add global layout for Insight pages.
     *
     * @param \Insight\Inertia\View\Component $layout
     * @return $this
     */
    public function addGlobalLayout(Component $layout): static
    {
        $this->layouts->add($layout);

        return $this;
    }

    /**
     * Retrieves global layouts for Insight pages.
     *
     * @return \Insight\Inertia\View\LayoutStack
     */
    public function getLayouts(): LayoutStack
    {
        return $this->layouts;
    }

    /**
     * Renders given page as Insight page.
     *
     * @param string $page
     * @param array $data
     * @return \Insight\View\Pages\InsightPage
     */
    public function render(string $page, array $data = []): InsightPage
    {
        return InsightPage::render($page)->with($data);
    }

    /**
     * Register given Resource within Insight.
     *
     * @param \Insight\Resources\Resource|string $resource
     * @return void
     */
    public function registerResource(Resource|string $resource): void
    {
        if (is_string($resource)) {
            $resource = app($resource);
        }

        $this->resources[$resource->getResourceLongName()] = $resource;

        $this->bootResource($resource);
    }

    /**
     * Boot the resource.
     *
     * @param \Insight\Resources\Resource $resource
     * @return void
     */
    protected function bootResource(Resource $resource): void
    {
        if (method_exists($resource, 'boot')) {
            $resource->boot();
        }
    }

    /**
     * Search for resource by class name.
     *
     * @param string $class
     * @return \Insight\Resources\Resource|null
     */
    public function findResourceByClassName(string $class): ?Resource
    {
        if (Arr::has($this->resources, $class)) {
            return $this->resources[$class];
        }

        return null;
    }

    /**
     * Find resource by routing key.
     *
     * @param string $key
     * @return \Insight\Resources\Resource|null
     */
    protected function findResourceByRoutingKey(string $key): ?Resource
    {
        foreach ($this->resources as $resource) {
            if ($resource->routingKey() === $key) {
                return $resource;
            }
        }

        return null;
    }

    /**
     * Resolve resource from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Insight\Resources\Resource|null
     */
    public function resolveResourceFromRequest(Request $request): ?Resource
    {
        if ($request->route()->hasParameter('resource')) {
            return $this->findResourceByRoutingKey($request->route('resource'));
        }

        if ($request->has('resource')) {
            return $this->findResourceByClassName($request->input('resource'));
        }

        if ($this->resolveResourceFromRequestUsing instanceof Closure) {
            return call_user_func($this->resolveResourceFromRequestUsing, $request);
        }

        return null;
    }

    /**
     * Retrieve collection of registered resources.
     *
     * @param bool $onlyApplication
     * @return \Illuminate\Support\Collection
     */
    public function getResources(bool $onlyApplication = false): Collection
    {
        return collect($this->resources)
            ->values()
            ->when($onlyApplication, function (Collection $resources) {
                return $resources->filter(fn (Resource $resource) => str_starts_with($resource->getResourceLongName(), app()->getNamespace()));
            });
    }

    /**
     * Register Insight Resources from given directory.
     *
     * @param string $directory
     * @return void
     */
    public function registerResourcesIn(string $directory): void
    {
        collect((new Finder())->files()->name('*.php')->in($directory))->each(function (SplFileInfo $file) {
            // Search for class namespace from file.
            preg_match_all('/^\s*namespace\s+(.*);$/m', $file->getContents(), $matches, PREG_SET_ORDER);
            if (count($matches) == 1 && count($matches[0]) == 2) {
                $clazz = $matches[0][1] . '\\' . $file->getFilenameWithoutExtension();

                if (class_exists($clazz) && Arr::has(class_parents($clazz), Resource::class)) {
                    if ((new \ReflectionClass($clazz))->isInstantiable()) {
                        $this->registerResource($clazz);
                    }
                }
            }
        });
    }
}
