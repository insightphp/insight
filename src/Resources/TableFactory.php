<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Pressable;
use Insight\Elements\View\Components\Stack;
use Insight\Elements\View\Components\Text;
use Insight\Tables\EloquentDataTable;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\DataTable;
use Insight\Tables\View\Components\Header;
use Insight\Tables\View\Components\Row;
use Insight\View\Components\Heroicon;
use Insight\View\Components\Menu;
use Insight\View\Models\Navigation;

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
                // Actions
                Cell::make()->displayAsHeader()->right(),
            ]
        ]);
    }

    public function createRowForModel(Collection $fields, Model $model): Row
    {
        $cells = $fields->map(function (Field $field) use ($model) {
            $component = $field->createTableField($this->resource, $model);

            $cell = Cell::make(['value' => $component]);

            return $cell;
        })->all();

        // TODO: Actions
        $actions = Stack::of([
            Link::toRoute('Edit', 'insight.resources.edit', [
                'resource' => $this->resource->routingKey(),
                'id' => $this->resource->getRoutingIdentifier($model),
            ])->withPressableContent(Heroicon::solid('pencil')),

            Link::toRoute('Show', 'insight.resources.show', [
                'resource' => $this->resource->routingKey(),
                'id' => $this->resource->getRoutingIdentifier($model),
            ])->withContent(Pressable::for(Heroicon::solid('eye'))->primary()),
        ]);

        return Row::make([
            'cells' => [
                // Field cels
                ...$cells,
                // Actions
                Cell::make(['value' => $actions])->right(),
            ]
        ])->id($model->getKey());
    }

    /**
     * Create data table of resource models.
     *
     * @return \Insight\Tables\View\Components\DataTable
     */
    public function createDataTable(): DataTable
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

        return $builder->toDataTable();
    }
}
