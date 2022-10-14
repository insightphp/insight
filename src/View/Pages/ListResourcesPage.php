<?php


namespace Insight\View\Pages;


use Illuminate\Http\Request;
use Insight\Resources\Resource;
use Insight\Tables\View\Components\DataTable;
use Insight\View\Components\Filter;

class ListResourcesPage extends InsightPage
{
    protected ?string $page = 'insight:ListResourcesPage';

    /**
     * Table of resources.
     *
     * @var \Insight\Tables\View\Components\DataTable
     */
    public DataTable $resources;

    /**
     * The filter for resources.
     *
     * @var \Insight\View\Components\Filter|null
     */
    public ?Filter $filter = null;

    /**
     * Determine if the resources are searchable.
     *
     * @var bool
     */
    public bool $isSearchable = false;

    public function __construct(
        protected Request $request,
        protected Resource $resource
    ) {
        $tableFactory = $resource->newTable($request);

        $this->resources = $tableFactory->createDataTable();

        $this->isSearchable = $this->resource->isSearchable();
    }
}
