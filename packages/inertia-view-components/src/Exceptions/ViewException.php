<?php


namespace Insight\Inertia\Exceptions;


class ViewException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
