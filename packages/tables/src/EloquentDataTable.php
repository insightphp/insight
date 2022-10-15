<?php


namespace Insight\Tables;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Insight\Inertia\View\Component;
use Insight\Tables\View\Components\DataTable;
use Insight\Tables\View\Components\Header;
use Insight\View\Components\Filter;

class EloquentDataTable
{
    /**
     * The table header.
     *
     * @var \Insight\Tables\View\Components\Header|null
     */
    protected ?Header $header = null;

    /**
     * Custom component for header actions.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    protected ?Component $headerActions = null;

    /**
     * Callback for creating row.
     *
     * @var \Closure|null
     */
    protected ?\Closure $createRowUsing = null;

    /**
     * Set the custom callback for search functionality.
     *
     * @var \Closure|null
     */
    protected ?\Closure $searchUsing = null;

    /**
     * Array of allowed sortings.
     *
     * @var array
     */
    protected array $allowedSorts = [];

    /**
     * Default sort as.
     *
     * @var string|null
     */
    protected ?string $defaultSortAs = null;

    /**
     * Default sorting direction.
     *
     * @var string
     */
    protected string $defaultSortDirection = 'desc';

    /**
     * The filter applied on the table.
     *
     * @var \Insight\View\Components\Filter|null
     */
    protected ?Filter $filter = null;

    /**
     * Resolved models.
     *
     * @var \Illuminate\Pagination\LengthAwarePaginator|null
     */
    protected ?LengthAwarePaginator $models = null;

    public function __construct(
        protected Builder $builder,
        protected Request $request,
        protected string $title
    ) {}

    public function withFilter(Filter $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function defaultSortAs(string $column, string $direction = 'desc'): static
    {
        $this->defaultSortAs = $column;
        $this->defaultSortDirection = $direction;

        return $this;
    }

    public function allowedSorts(array $sorts): static
    {
        $this->allowedSorts = $sorts;

        return $this;
    }

    public function withHeader(Header $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function withHeaderActions(Component $component): static
    {
        $this->headerActions = $component;

        return $this;
    }

    protected function perPage(): int
    {
        $value = $this->request->query('limit');

        if (is_numeric($value)) {
            return $value;
        }

        return 25;
    }

    public function fetchModels(): LengthAwarePaginator
    {
        $builder = $this->builder->clone();

        $this->applyFilter($builder);

        $this->applySearch($builder);

        $this->applySortings($builder);

        return $builder->paginate(
            $this->perPage()
        )->onEachSide(1)->withQueryString();
    }

    public function getModelCollection(): Collection
    {
        return Collection::make($this->getModels()->items());
    }

    public function getModels(): LengthAwarePaginator
    {
        if ($this->models instanceof LengthAwarePaginator) {
            return $this->models;
        }

        return $this->models = $this->fetchModels();
    }

    protected function createRows(array $items): array
    {
        if ($this->createRowUsing instanceof \Closure) {
            return collect($items)->map($this->createRowUsing)->all();
        }

        throw new \LogicException("The [createRowUsing] callback is not set.");
    }

    public function createRowUsing(\Closure $closure): static
    {
        $this->createRowUsing = $closure;

        return $this;
    }

    protected function getSearchTerm(): ?string
    {
        $term = $this->request->query('s');

        if (is_string($term) && strlen($term) > 0) {
            return $term;
        }

        return null;
    }

    public function applySearch(Builder $builder): void
    {
        $term = $this->getSearchTerm();

        if ($this->searchUsing instanceof \Closure && $term != null) {
            call_user_func($this->searchUsing, $builder, $term);
        }
    }

    protected function applyFilter(Builder $builder): void
    {
        if ($this->filter instanceof Filter) {
            $this->filter->applyOnEloquentBuilder($builder);
        }
    }

    protected function sortAs(): ?string
    {
        return $this->request->query('sort_by');
    }

    protected function sortDirection(): string
    {
        $direction = $this->request->query('sort_as');

        return $direction === 'asc' ? $direction : 'desc';
    }

    public function applySortings(Builder $builder): void
    {
        $sortAs = $this->sortAs();

        if (is_string($sortAs) && in_array($sortAs, $this->allowedSorts)) {
            $builder->orderBy($sortAs, $this->sortDirection());
        } else if (is_string($this->defaultSortAs)) {
            $builder->orderBy($this->defaultSortAs, $this->defaultSortDirection);
        }
    }

    public function searchUsing(\Closure $closure): static
    {
        $this->searchUsing = $closure;

        return $this;
    }

    public function toDataTable(): DataTable
    {
        $models = $this->getModels();

        $table = DataTable::make([
            'title' => $this->title,
            'totalItems' => $models->total(),
            'lastPage' => $models->lastPage(),
            'currentPage' => $models->currentPage(),
            'header' => $this->header,
            'headerActions' => $this->headerActions,
            'rows' => $this->createRows($models->items()),
        ])->addPaginationLinks($models->linkCollection())->withBulkSelection();

        if ($this->defaultSortAs) {
            $table->defaultSortAs($this->defaultSortAs, $this->defaultSortDirection);
        }

        return $table->withBulkSelection(false);
    }
}
