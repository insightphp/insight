<?php


namespace Insight\View\Pages;


use Insight\Tables\View\Components\DataTable;

class ListResourcesPage extends InsightPage
{
    protected ?string $page = 'insight:ListResourcesPage';

    /**
     * Table of resources.
     *
     * @var \Insight\Tables\View\Components\DataTable|null
     */
    public ?DataTable $resources = null;
}
