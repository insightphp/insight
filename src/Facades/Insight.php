<?php


namespace Insight\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static \Insight\View\Pages\InsightPage render(string $page, array $data = [])
 * @method static void registerResourcesIn(string $directory)
 * @method static \Illuminate\Support\Collection getResources(bool $onlyApplication = false)
 *
 * @see \Insight\Insight
 */
class Insight extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'insight';
    }
}
