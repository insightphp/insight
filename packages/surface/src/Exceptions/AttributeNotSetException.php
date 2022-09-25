<?php


namespace Insight\Inertia\Exceptions;


class AttributeNotSetException extends ViewException
{
    public function __construct(
        string $attribute
    ) {
        parent::__construct("The model attribute [$attribute] does not have any value.");
    }
}
