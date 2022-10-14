<?php


namespace Insight\View\Components;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;
use Insight\View\Components\Filterables\Filterable;

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

    public function filterable(Filterable $filterable): static
    {
        $this->filterables[] = $filterable;

        return $this;
    }

    public function fillValueFromRequest(Request $request): static
    {
        collect($this->filterables)->each(function (Filterable $filterable) use ($request) {
            if ($filterable->isValueInRequest($request)) {
                $this->value[$filterable->id] = $filterable->getValueFromRequest($request);
            }
        });

        return $this;
    }

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
}
