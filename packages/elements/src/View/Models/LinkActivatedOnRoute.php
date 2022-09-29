<?php


namespace Insight\Elements\View\Models;


use Insight\Inertia\View\Model;

class LinkActivatedOnRoute extends Model
{
    /**
     * The route name.
     *
     * @var string
     */
    public string $route;

    /**
     * Params of the activated route.
     *
     * @var array
     */
    public array $params = [];
}
