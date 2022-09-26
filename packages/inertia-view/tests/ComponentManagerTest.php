<?php

use Insight\Inertia\Tests\Fixtures;

test('it should register component', function () {
    expect(components()->addComponent(Fixtures\Components\UserComponent::class, 'inertia-view'))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getNamespace()
        ->toBe('inertia-view')
        ->getPath()
        ->toBe('UserComponent');
});

test('it should register component within different namespace root', function ($namespace) {
    expect(components()->addComponent(Fixtures\Components\UserComponent::class, 'inertia-view', $namespace))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getNamespace()
        ->toBe('inertia-view')
        ->getPath()
        ->toBe('Components/UserComponent');
})->with(['Components', '/Components', 'Components/']);

test('it should register components from directory', function () {
    $path = __DIR__ . '/Fixtures/Components';

    $registeredComponents = components()->addComponentsFromPath($path, 'inertia-view');

    expect($registeredComponents)->toHaveCount(2)
        ->and($registeredComponents->first(fn(\Insight\Inertia\ResolvedComponent $component) => $component->getClass() === Fixtures\Components\UserComponent::class))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getClass()->toBe(Fixtures\Components\UserComponent::class)
        ->getNamespace()->toBe('inertia-view')
        ->getPath()->toBe('UserComponent')
        ->and($registeredComponents->first(fn(\Insight\Inertia\ResolvedComponent $component) => $component->getClass() === Fixtures\Components\Customers\Avatar::class))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getClass()->toBe(Fixtures\Components\Customers\Avatar::class)
        ->getNamespace()->toBe('inertia-view')
        ->getPath()->toBe('Customers/Avatar');
});

it('should register components via test helper')
    ->expect(components(discover: true))
    ->getRegisteredComponents()
    ->toHaveCount(2);

it('should resolve component by class name')
    ->expect(components(true)->resolve(Fixtures\Components\UserComponent::class))
    ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
    ->and(components(true)->resolve(Fixtures\Components\Customers\Avatar::class))
    ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class);

it('should resolve component by custom path')
    ->expect(components(true)->resolve('inertia-view:UserComponent'))
    ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class);

it('should register components to single namespace from multiple paths', function () {
    $manager = components();
    $manager->addComponentsFromPath(__DIR__ .'/Fixtures/Components', 'inertia-view');
    $manager->addComponentsFromPath(__DIR__ .'/Fixtures/OtherPackage/Components', 'inertia-view');

    expect($manager->getRegisteredComponents())
        ->toHaveCount(3)
        ->and($manager->resolve(Fixtures\OtherPackage\Components\PackageProvidedComponent::class))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getPath()->toBe('PackageProvidedComponent');
});

it('should automatically register components defined in config', function () {
    expect(config('inertia-view.components.inertia-view'))->toBe(realpath(__DIR__ . '/Fixtures/Components'))
        ->and(app(\Insight\Inertia\ComponentManager::class)->getRegisteredComponents())
        ->toHaveCount(2);
});
