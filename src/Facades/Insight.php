<?php


namespace Insight\Facades;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Insight\View\Pages\InsightPage render(string $page, array $data = [])
 * @method static void registerResourcesIn(string $directory)
 * @method static \Illuminate\Support\Collection getResources(bool $onlyApplication = false)
 * @method static \Insight\Resources\Resource|null resolveResourceFromRequest(Request $request)
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
