<?php


namespace Insight\Inertia\View;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Insight\Inertia\Contracts\HasInertiaProps;
use Insight\Inertia\Exceptions\AttributeNotSetException;
use Insight\Inertia\Exceptions\MissingAttributeException;
use ReflectionClass;
use ReflectionProperty;

abstract class Model implements HasInertiaProps
{
    /**
     * Serialize model for Inertia.
     *
     * @return array|\Closure|null
     */
    public function toInertia(): array|\Closure|null
    {
        $clazz = new ReflectionClass($this);

        // Serialize all public properties.
        return collect($clazz->getProperties(ReflectionProperty::IS_PUBLIC))
            ->reduce(function (array $model, ReflectionProperty $property) {
                $model[$property->getName()] = $this->prepareForInertia($this->{$property->getName()});

                return $model;
            }, []);
    }

    /**
     * Prepare value of the attribute for Inertia.
     *
     * @param $value
     * @return mixed
     */
    protected function prepareForInertia($value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        if (is_iterable($value)) {
            return collect($value)->map(fn ($entry) => $this->prepareForInertia($entry))->all();
        }

        if ($value instanceof Model) {
            return $value->toInertia();
        }

        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }

    /**
     * Create new model from array of attributes.
     *
     * @param array $attributes
     * @return static
     */
    public static function make(array $attributes = []): static
    {
        return tap(new static, function ($model) use ($attributes) {
            $clazz = new ReflectionClass(static::class);

            $availableProps = collect($clazz->getProperties(ReflectionProperty::IS_PUBLIC|ReflectionProperty::IS_PROTECTED));

            foreach ($availableProps as $property) {
                $attribute = $property->getName();

                if (Arr::has($attributes, $attribute)) {
                    $model->$attribute = $attributes[$attribute];
                } else if ($property->getType()?->allowsNull() && !$property->hasDefaultValue()) {
                    $model->$attribute = null;
                } else if ($property->getType()?->allowsNull() === false && !$property->hasDefaultValue()) {
                    throw new AttributeNotSetException($property->getName());
                }
            }

            // Throw exception for every additional attribute which does not have public or protected property.
            $publicPropNames = $availableProps->map(fn(ReflectionProperty $property) => $property->getName())->all();
            foreach (collect(array_keys($attributes))->filter(fn($attribute) => !in_array($attribute, $publicPropNames)) as $attribute) {
                throw new MissingAttributeException($attribute, static::class);
            }
        });
    }
}
