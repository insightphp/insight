<?php


namespace Insight\Inertia\Exceptions;


class MissingAttributeException extends ViewException
{
    public function __construct(
        string $attribute,
        string $model,
    ) {
        parent::__construct("The model attribute [$attribute] does not exist on model [$model].");
    }
}
