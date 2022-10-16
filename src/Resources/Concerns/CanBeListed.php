<?php


namespace Insight\Resources\Concerns;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Insight\Resources\Field;
use Insight\Resources\Sorting;
use Insight\Resources\TableFactory;
use Insight\View\Pages\ListResourcesPage;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CanBeListed
{
    /**
     * Creates new table factory for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Insight\Resources\TableFactory
     */
    public function newTable(Request $request): TableFactory
    {
        return new TableFactory($request, $this);
    }

    /**
     * Retrieve the table name.
     *
     * @return string
     */
    public function getTitleForTable(): string
    {
        return $this->getDisplayPluralName();
    }

    /**
     * The default sorting for the resource.
     *
     * @return \Insight\Resources\Sorting|null
     */
    public function getDefaultSorting(): ?Sorting
    {
        return Sorting::desc('id');
    }

    /**
     * Retrieve list of fields which can be displayed on the table.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTableFields(): Collection
    {
        return $this->getFieldCollection()->filter(function (Field $field) {
            return $field->hasTableField();
        });
    }

    /**
     * Create new index page for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Insight\View\Pages\ListResourcesPage
     */
    public function toIndexPage(Request $request): ListResourcesPage
    {
        return new ListResourcesPage($request, $this);
    }
}
