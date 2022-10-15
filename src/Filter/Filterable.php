<?php


namespace Insight\Filter;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Insight\Inertia\View\Component;
use Insight\View\Components\Filter;

abstract class Filterable extends Component
{

    /**
     * The unique identifier of the filter.
     *
     * @var string
     */
    public string $id;

    /**
     * The title of the filter.
     *
     * @var string
     */
    public string $title;

    /**
     * Custom callback for applying filterable on the Eloquent Builder.
     *
     * @var \Closure|null
     */
    protected ?\Closure $applyOnEloquentUsing = null;

    /**
     * Retrieve empty value of the filterable.
     *
     * @return mixed
     */
    public function getEmptyValue(): mixed
    {
        return null;
    }

    /**
     * Determine if the value of the filterable is empty.
     *
     * @param mixed $value
     * @return bool
     */
    public function isValueConsideredEmpty(mixed $value): bool
    {
        return $this->getEmptyValue() === $value;
    }

    /**
     * Determine if value of the filterable is present in the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isValueInRequest(Request $request): bool
    {
        return $request->query->has($this->id);
    }

    /**
     * Retrieve value of the filterable from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getValueFromRequest(Request $request): mixed
    {
        return $request->query($this->id);
    }

    /**
     * Set custom callback for applying the filterable on Eloquent Builder.
     *
     * @param \Closure $callback
     * @return $this
     */
    public function applyOnEloquentUsing(\Closure $callback): static
    {
        $this->applyOnEloquentUsing = $callback;

        return $this;
    }

    /**
     * Applies filter on Eloquent builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @param \Insight\View\Components\Filter $filter
     * @return void
     */
    public function applyOnEloquentBuilder(Builder $query, mixed $value, Filter $filter): void
    {
        if ($this->applyOnEloquentUsing instanceof \Closure) {
            call_user_func($this->applyOnEloquentUsing, $query, $value, $filter);
        }
    }
}
