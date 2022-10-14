<?php


namespace Insight\View\Pages;


use Insight\Tables\View\Components\DataTable;
use Insight\View\Components\Filter;

class ListResourcesPage extends InsightPage
{
    protected ?string $page = 'insight:ListResourcesPage';

    /**
     * Table of resources.
     *
     * @var \Insight\Tables\View\Components\DataTable|null
     */
    public ?DataTable $resources = null;

    /**
     * The filter for resources.
     *
     * @var \Insight\View\Components\Filter|null
     */
    public ?Filter $filter = null;
}
