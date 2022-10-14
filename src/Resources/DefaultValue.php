<?php


namespace Insight\Resources;


use Insight\Inertia\View\Model;

class DefaultValue
{
    public function __construct(
        protected mixed $value = null
    ) {}

    public function get(Resource $resource, ?Model $model): mixed
    {
        return value($this->value, $resource, $model);
    }
}
