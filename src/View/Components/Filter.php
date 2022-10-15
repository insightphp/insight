<?php


namespace Insight\View\Components;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Insight\Filter\Filterable;
use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;

class Filter extends Component
{
    /**
     * Array of filterables for the filter.
     *
     * @var array
     */
    public array $filterables = [];

    /**
     * Current value of the filter.
     *
     * @var array
     */
    protected array $value = [];

    /**
     * Add filterable to the filter.
     *
     * @param \Insight\Filter\Filterable $filterable
     * @return $this
     */
    public function filterable(Filterable $filterable): static
    {
        $this->filterables[] = $filterable;

        return $this;
    }

    /**
     * Fills values of Filterables from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return $this
     */
    public function fillValueFromRequest(Request $request): static
    {
        collect($this->filterables)->each(function (Filterable $filterable) use ($request) {
            if ($filterable->isValueInRequest($request)) {
                $this->value[$filterable->id] = $filterable->getValueFromRequest($request);
            }
        });

        return $this;
    }

    /**
     * Retrieve value of the Filterable.
     *
     * @param \Insight\Filter\Filterable $filterable
     * @return mixed
     */
    public function getValueOfFilterable(Filterable $filterable): mixed
    {
        if (Arr::has($this->value, $filterable->id)) {
            return $this->value[$filterable->id];
        }

        return $filterable->getEmptyValue();
    }

    #[Computed(name: 'initialValue')]
    public function getInitialValue(): array
    {
        return collect($this->filterables)->mapWithKeys(function (Filterable $filterable) {
           $value = $this->getValueOfFilterable($filterable);

            return [
                $filterable->id => [
                    'selected' => ! $filterable->isValueConsideredEmpty($value),
                    'value' => $value,
                ]
            ];
        })->all();
    }

    /**
     * Determine if the filter is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->filterables);
    }

    /**
     * Applies filter on the Eloquent query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function applyOnEloquentBuilder(Builder $builder): void
    {
        collect($this->filterables)->each(function (Filterable $filterable) use ($builder) {
            $value = $this->getValueOfFilterable($filterable);

            if ($filterable->isValueConsideredEmpty($value)) {
                return;
            }

            $filterable->applyOnEloquentBuilder($builder, $value, $this);
        });
    }
}
