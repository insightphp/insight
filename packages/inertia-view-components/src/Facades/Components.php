<?php


namespace Insight\Inertia\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @see \Insight\Inertia\ComponentManager
 */
class Components extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'surface.components';
    }
}
