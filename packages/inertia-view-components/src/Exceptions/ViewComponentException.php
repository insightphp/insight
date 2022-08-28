<?php


namespace Insight\Inertia\Exceptions;


class ViewComponentException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
