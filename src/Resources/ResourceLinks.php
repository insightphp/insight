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
     * Retrieve URL to the index page of the resource.
     *
     * @return string
     */
    public function index(): string
    {
        return route('insight.resources.index', $this->resource->routingKey());
    }

    /**
     * Retrieve list of routes where the link should be marked as activated.
     *
     * @return array[]
     */
    public function getActivationRoutes(): array
    {
        return [
            'insight.resources.index' => [
                'resource' => $this->resource->routingKey(),
            ]
        ];
    }
}
