<?php


namespace Insight\View\Pages;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Insight\Resources\Resource;
use Insight\Tables\View\Components\DataTable;
use Insight\View\Components\Dialogs\DestroyResourcesDialog;
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

    /**
     * Available bulk actions for models.
     *
     * @var array
     */
    public array $bulkActions = [];

    public function __construct(
        protected Request $request,
        protected Resource $resource
    ) {
        $tableFactory = $resource->newTable($request);

        $tableBudiler = $tableFactory->getDataTableBuilder();

        $filter = $tableFactory->buildFilter();

        $filter->fillValueFromRequest($this->request);

        $tableBudiler->withFilter($filter);

        $this->bulkActions = $tableFactory->getBulkActions($tableBudiler->getModelCollection());

        $this->resources = $tableBudiler->toDataTable();

        if (! empty($this->bulkActions)) {
            $this->resources->withBulkSelection();
        }

        $this->isSearchable = $this->resource->isSearchable();

        if (! $filter->isEmpty()) {
            $this->filter = $filter;
        }

        $this->dialog('destroy-resources', function (array $data) {
            $selectedResources = collect(Arr::get($data, 'resources', []))
                ->filter(fn ($id) => is_numeric($id));

            if ($selectedResources->isEmpty()) {
                return null;
            }

            $model = $this->resource->newModel();

            $resources = $this->resource->newIndexQuery()
                ->whereIn($model->getRouteKeyName(), $selectedResources)
                ->get()
                ->filter(fn (Model $model) => $this->resource->canDeleteResource($model));

            if ($resources->isEmpty()) {
                return null;
            }

            return $this->resource->createDestroyDialog($resources);
        });
    }
}
