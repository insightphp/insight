<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;

class ResourceLinks
{
    public function __construct(
        protected Resource $resource,
        protected ?Model $model
    ) {}

    /**
     * Requires model for given link.
     *
     * @param string $link
     * @return void
     */
    protected function ensureModelProvided(string $link): void
    {
        if ($this->model === null) {
            throw new \LogicException("The model is required for [$link] link to be generated.");
        }
    }

    /**
     * Retrieve URL to the index page of the resource.
     *
     * @return string
     */
    public function index(): string
    {
        return route('insight.resources.index', $this->resource->routingKey());
    }

    /**
     * Retrieve URL to resource detail.
     *
     * @return string
     */
    public function show(): string
    {
        $this->ensureModelProvided('show');

        return route('insight.resources.show', [
            'resource' => $this->resource->routingKey(),
            'id' => $this->resource->getRoutingIdentifier($this->model),
        ]);
    }

    /**
     * Retrieve URL to resource creation form.
     *
     * @return string
     */
    public function create(): string
    {
        return route('insight.resources.create', $this->resource->routingKey());
    }

    /**
     * Retrieve URL for creating resource.
     *
     * @return string
     */
    public function store(): string
    {
        return route('insight.resources.store', $this->resource->routingKey());
    }

    /**
     * Retrieve URL for resource update form.
     *
     * @return string
     */
    public function edit(): string
    {
        $this->ensureModelProvided('edit');

        return route('insight.resources.edit', [
            'resource' => $this->resource->routingKey(),
            'id' => $this->resource->getRoutingIdentifier($this->model),
        ]);
    }

    /**
     * Retrieve URL for updating the resource.
     *
     * @return string
     */
    public function update(): string
    {
        $this->ensureModelProvided('update');

        return route('insight.resources.update', [
            'resource' => $this->resource->routingKey(),
            'id' => $this->resource->getRoutingIdentifier($this->model),
        ]);
    }

    /**
     * Retrieve URL for resource deletion.
     *
     * @return string
     */
    public function destroy(): string
    {
        $this->ensureModelProvided('destroy');

        return route('insight.resources.destroy', [
            'resource' => $this->resource->routingKey(),
            'id' => $this->resource->getRoutingIdentifier($this->model),
        ]);
    }

    /**
     * Retrieve URL for deleting multiple resources.
     *
     * @return string
     */
    public function destroyMany(): string
    {
        return route('insight.resources.destroy-many', $this->resource->routingKey());
    }

    /**
     * Retrieve list of routes where the link should be marked as activated.
     *
     * @return array[]
     */
    public function getActivationRoutes(): array
    {
        $routes = [
            'insight.resources.index' => [
                'resource' => $this->resource->routingKey(),
            ],
            'insight.resources.create' => [
                'resource' => $this->resource->routingKey(),
            ],
            'insight.resources.store' => [
                'resource' => $this->resource->routingKey(),
            ],
            'insight.resources.destroy-many' => [
                'resource' => $this->resource->routingKey(),
            ],
        ];

        if ($this->model != null) {
            $routes = array_merge($routes, [
                'insight.resources.show' => [
                    'resource' => $this->resource->routingKey(),
                    'id' => $this->resource->getRoutingIdentifier($this->model),
                ],
                'insight.resources.edit' => [
                    'resource' => $this->resource->routingKey(),
                    'id' => $this->resource->getRoutingIdentifier($this->model),
                ],
                'insight.resources.update' => [
                    'resource' => $this->resource->routingKey(),
                    'id' => $this->resource->getRoutingIdentifier($this->model),
                ],
                'insight.resources.destroy' => [
                    'resource' => $this->resource->routingKey(),
                    'id' => $this->resource->getRoutingIdentifier($this->model),
                ],
            ]);
        }

        return $routes;
    }
}
