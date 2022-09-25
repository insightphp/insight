<?php


namespace Insight\Inertia;


use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use ReflectionProperty;

/**
 * @deprecated
 */
class ViewSerializer
{
    /**
     * Serialize View Component to array.
     *
     * @param \Insight\Inertia\ViewComponent $component
     * @return array
     */
    public function serialize(ViewComponent $component): array
    {
        return collect((new ReflectionClass($component))->getProperties(ReflectionProperty::IS_PUBLIC))
            ->mapWithKeys(
                fn (ReflectionProperty $property) => [$property->getName() => $this->serializeValue($property->getValue($component))]
            )
            ->all();
    }

    protected function serializeValue($value): mixed
    {
        if (is_null($value)) {
            return $value;
        }

        if (is_iterable($value)) {
            return collect($value)->map(fn($item) => $this->serializeValue($item))->all();
        }

        if ($value instanceof ViewComponent) {
            return $value->toInertia();
        }

        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        if (is_object($value)) {
            // TODO: Not sure if this will work.
            return (array) $value;
        }

        return $value;
    }

}
