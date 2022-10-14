<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * List of searchable columns.
     * Supports nested relations.
     *
     * @var array
     */
    protected array $searchable = [];

    /**
     * Determine if the resource is searchable.
     *
     * @return bool
     */
    public function isSearchable(): bool
    {
        return ! empty($this->searchable);
    }

    /**
     * Apply the search to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return void
     */
    public function search(Builder $query, string $term): void
    {
        $query->where(function (Builder $q) use ($term) {
            foreach ($this->searchable as $column) {
                if (str_contains($column, '.')) {
                    dd('TODO: MUSIM IMPLMENETOVAT RELATION SEARCH');
                } else {
                    $q->orWhere($column, 'like', '%'. $term . '%');
                }
            }
        });
    }
}
