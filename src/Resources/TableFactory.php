<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Pressable;
use Insight\Elements\View\Components\Stack;
use Insight\Elements\View\Components\Text;
use Insight\Inertia\View\Component;
use Insight\Tables\EloquentDataTable;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\DataTable;
use Insight\Tables\View\Components\Header;
use Insight\Tables\View\Components\Row;
use Insight\View\Components\Heroicon;

class TableFactory
{

    public function __construct(
        protected Request $request,
        protected Resource $resource,
    ) {}

    /**
     * Create table header for given list of fields.
     *
     * @param \Illuminate\Support\Collection $fields
     * @return \Insight\Tables\View\Components\Header
     */
    protected function createHeader(Collection $fields): Header
    {
        $cells = $fields->map(function (Field $field) {
            $cell = Cell::make([
                'value' => Text::of($field->getTitleForTableColumn())
            ])->displayAsHeader();

            if ($field->isSortable()) {
                $cell->sortableAs($field->getSortableAs());
            }

            return $cell;
        })->all();

        return Header::make([
            'cells' => [
                // Fields cells
                ...$cells,
                // Actions - TODO: Add actions only if there are some.
                Cell::make()->displayAsHeader()->right(),
            ]
        ]);
    }

    /**
     * Resolve available bulk actions on the resource.
     *
     * @param \Illuminate\Support\Collection $models
     * @return array
     */
    public function getBulkActions(Collection $models): array
    {
        $actions = [];

        // Destroy many action..
        if ($models->some(fn (Model $model) => $this->resource->canDeleteResource($model))) {
            $actions[] = Link::toDialog('Delete', 'destroy-resources');
        }

        return $actions;
    }

    /**
     * Builds actions component for given model. The actions component is
     * inserted as last cell in the row.
     *
     * @param \Illuminate\Support\Collection $fields
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Inertia\View\Component|null
     */
    protected function resolveActionsForModel(Collection $fields, Model $model): ?Component
    {
        $resourceLinks = $this->resource->createLinks($model);

        $actions = Stack::make();

        if ($this->resource->canDeleteResource($model)) {
            $actions->add(
                Link::toDialog('Delete', 'destroy-resources', [
                    'resources' => [$this->resource->getRoutingIdentifier($model)]
                ])->withContent(Pressable::for(Heroicon::solid('trash'))->danger())
            );
        }

        if ($this->resource->canUpdateResource($model)) {
            $actions->add(
                Link::toLocation('Edit', $resourceLinks->edit())
                    ->withPressableContent(Heroicon::solid('pencil'))
            );
        }

        if ($this->resource->canViewResource($model)) {
            $actions->add(
                Link::toLocation('Show', $resourceLinks->show())
                    ->withPressableContent(Heroicon::solid('eye'))
            );
        }

        if (! $actions->isEmpty()) {
            return $actions;
        }

        return null;
    }

    public function createRowForModel(Collection $fields, Model $model): Row
    {
        $cells = $fields->map(function (Field $field) use ($model) {
            $component = $field->createTableField($this->resource, $model);

            $cell = Cell::make(['value' => $component]);

            return $cell;
        })->all();

        $actions = $this->resolveActionsForModel($fields, $model);

        if ($actions instanceof Component) {
            $cells[] = Cell::make(['value' => $actions])->right();
        }

        return Row::make([
            'cells' => $cells,
        ])->id($model->getKey());
    }

    /**
     * Retrieve the data table builder.
     *
     * @return \Insight\Tables\EloquentDataTable
     */
    public function getDataTableBuilder(): EloquentDataTable
    {
        $builder = new EloquentDataTable(
            builder: $this->resource->newIndexQuery(),
            request: $this->request,
            title: $this->resource->getTitleForTable()
        );

        $sorting = $this->resource->getDefaultSorting();

        if ($sorting instanceof Sorting) {
            $builder->defaultSortAs($sorting->getColumn(), $sorting->getDirection());
        }

        $fields = $this->resource->getTableFields()->filter(function (Field $field) {
            return $field->isVisibleOnList($this->resource, $this->resource->newModel());
        });

        // Table header
        $builder->withHeader($this->createHeader($fields));

        // Rows
        $builder->createRowUsing(function (Model $model) use ($fields) {
            return $this->createRowForModel($fields, $model);
        });

        // Add allowed sortings
        $builder->allowedSorts(
            $fields
                ->filter(fn (Field $field) => $field->isSortable())
                ->map(fn (Field $field) => $field->getSortableAs())
                ->all()
        );

        // Search
        if ($this->resource->isSearchable()) {
            $builder->searchUsing(function (Builder $query, string $term) {
                $this->resource->search($query, $term);
            });
        }

        return $builder;
    }
}
