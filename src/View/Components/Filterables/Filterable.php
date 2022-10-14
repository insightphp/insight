<?php


namespace Insight\View\Components\Filterables;


use Illuminate\Http\Request;
use Insight\Inertia\View\Component;

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

    public function getInitialValue(): mixed
    {
        return null;
    }

    public function getEmptyValue(): mixed
    {
        return null;
    }

    public function isValueConsideredEmpty(mixed $value): bool
    {
        return $this->getEmptyValue() === $value;
    }

    public function isValueInRequest(Request $request): bool
    {
        return $request->query->has($this->id);
    }

    public function getValueFromRequest(Request $request): mixed
    {
        return $request->query($this->id);
    }
}
