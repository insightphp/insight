<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Builder;
use Insight\Filter\Filterable as FilterableComponent;
use Insight\View\Components\Filterables\BooleanFilterable;

/**
 * @mixin \Insight\Resources\Resource
 */
trait Filterable
{
    /**
     * Creates new trashed filterable.
     *
     * @return \Insight\Filter\Filterable
     */
    public function createTrashedFilterable(): FilterableComponent
    {
        return BooleanFilterable::make([
            'id' => 'with-trashed',
            'title' => 'Trashed',
        ])->option('yes', 'Show Trashed')->applyOnEloquentUsing(function (Builder $builder, mixed $value) {
            if (is_array($value) && in_array('yes', $value)) {
                $builder->withTrashed();
            }
        });
    }

    /**
     * Determine if the resource can be filtered by trashed.
     *
     * @return bool
     */
    public function canFilterTrashed(): bool
    {
        return true;
    }
}
