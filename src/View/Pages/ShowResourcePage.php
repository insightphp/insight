<?php


namespace Insight\View\Pages;


use Illuminate\Database\Eloquent\Model;
use Insight\Resources\Resource;

class ShowResourcePage extends InsightPage
{
    protected ?string $page = 'insight:ShowResourcePage';

    public function __construct(
        protected Resource $resource,
        protected Model $model
    )
    {
        //
    }
}
