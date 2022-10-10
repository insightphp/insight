<?php


namespace Insight\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static \Insight\View\Pages\InsightPage render(string $page, array $data = [])
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
