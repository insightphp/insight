<?php


namespace Insight\Inertia\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static \Insight\Inertia\ResolvedComponent|null resolve(string $component)
 *
 * @see \Insight\Inertia\ComponentManager
 */
class Components extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'surface.components';
    }
}
