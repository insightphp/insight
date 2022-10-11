<?php


namespace Insight\View\Pages;


use Insight\Tables\View\Components\Table;

class ListResourcesPage extends InsightPage
{
    protected ?string $page = 'insight:ListResourcesPage';

    /**
     * Table of resources.
     *
     * @var \Insight\Tables\View\Components\Table|null
     */
    public ?Table $resources = null;
}
