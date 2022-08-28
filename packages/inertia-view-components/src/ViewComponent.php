<?php


namespace Insight\Inertia;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Insight\Inertia\Exceptions\ViewComponentException;
use ReflectionClass;

abstract class ViewComponent implements Arrayable, \JsonSerializable
{
    /**
     * Serialize view comopnent to array.
     *
     * @return array|\TValue[]
     */
    public function toArray()
    {
        return $this->toInertia();
    }

    /**
     * Serialize view component to json.
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->toInertia();
    }

    /**
     * Serialize view component for Inertia.
     *
     * @return array
     */
    public function toInertia(): array
    {
        return array_merge((new ViewSerializer)->serialize($this), [
            '_component' => [
                'name' => $this->resolveComponentName(),
            ],
        ]);
    }

    /**
     * Resolves the component name.
     *
     * @return string
     */
    protected function resolveComponentName(): string
    {
        $manager = app(ViewComponentManager::class);

        $namespace = (string) Str::of($manager->findNamespaceForComponent($this))->lower()->kebab();
        $name = (string) Str::of($manager->findComponentRelativeName($this))->replace('\\', '')->kebab();

        return "{$namespace}-{$name}";
    }

    /**
     * Creates new instance of the view component.
     *
     * @param array $attributes
     * @return static
     */
    public static function make(array $attributes = []): static
    {
        $clazz = new ReflectionClass(static::class);

        $component = new static;

        foreach ($attributes as $name => $value) {
            if ($clazz->hasProperty($name)) {
                $component->$name = $value;
            } else {
                throw new ViewComponentException("View component {$clazz->getName()} does not have public property $name.");
            }
        }

        return $component;
    }
}
