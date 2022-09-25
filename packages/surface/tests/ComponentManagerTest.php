<?php

use Insight\Inertia\Tests\Fixtures;

test('it should register component', function () {
    expect(components()->addComponent(Fixtures\Components\UserComponent::class, 'surface'))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getNamespace()
        ->toBe('surface')
        ->getPath()
        ->toBe('UserComponent');
});

test('it should register component within different namespace root', function ($namespace) {
    expect(components()->addComponent(Fixtures\Components\UserComponent::class, 'surface', $namespace))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getNamespace()
        ->toBe('surface')
        ->getPath()
        ->toBe('Components/UserComponent');
})->with(['Components', '/Components', 'Components/']);

test('it should register components from directory', function () {
    $path = __DIR__ . '/Fixtures/Components';

    $registeredComponents = components()->addComponentsFromPath($path, 'surface');

    expect($registeredComponents)->toHaveCount(2)
        ->and($registeredComponents->first(fn(\Insight\Inertia\ResolvedComponent $component) => $component->getClass() === Fixtures\Components\UserComponent::class))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getClass()->toBe(Fixtures\Components\UserComponent::class)
        ->getNamespace()->toBe('surface')
        ->getPath()->toBe('UserComponent')
        ->and($registeredComponents->first(fn(\Insight\Inertia\ResolvedComponent $component) => $component->getClass() === Fixtures\Components\Customers\Avatar::class))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getClass()->toBe(Fixtures\Components\Customers\Avatar::class)
        ->getNamespace()->toBe('surface')
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

it('should resolve component by Surface path')
    ->expect(components(true)->resolve('surface:UserComponent'))
    ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class);

it('should register components to single namespace from multiple paths', function () {
    $manager = components();
    $manager->addComponentsFromPath(__DIR__ .'/Fixtures/Components', 'surface');
    $manager->addComponentsFromPath(__DIR__ .'/Fixtures/OtherPackage/Components', 'surface');

    expect($manager->getRegisteredComponents())
        ->toHaveCount(3)
        ->and($manager->resolve(Fixtures\OtherPackage\Components\PackageProvidedComponent::class))
        ->toBeInstanceOf(\Insight\Inertia\ResolvedComponent::class)
        ->getPath()->toBe('PackageProvidedComponent');
});

it('should automatically register components defined in config', function () {
    expect(config('surface.components.surface'))->toBe(realpath(__DIR__ . '/Fixtures/Components'))
        ->and(app(\Insight\Inertia\ComponentManager::class)->getRegisteredComponents())
        ->toHaveCount(2);
});
