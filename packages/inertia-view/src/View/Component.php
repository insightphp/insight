<?php


namespace Insight\Inertia\View;


use Insight\Inertia\ComponentManager;
use Insight\Inertia\Exceptions\ViewException;
use Insight\Inertia\Support\Computed;

abstract class Component extends Model
{

    /**
     * Retrieve meta information about the component.
     *
     * @param \Insight\Inertia\ComponentManager $components
     * @return array
     */
    #[Computed(name: '_component')]
    public function getInertiaComponent(ComponentManager $components): array
    {
        $resolvedComponent = $components->resolve(static::class);

        if ($resolvedComponent == null) {
            throw new ViewException("The component [".get_class($this)."] is not registered.");
        }

        return [
            'name' => $resolvedComponent->getName(),
        ];
    }

}
