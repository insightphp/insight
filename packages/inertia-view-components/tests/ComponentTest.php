<?php

use Insight\Inertia\Tests\Fixtures;

test('it should create component', function () {
    $user = Fixtures\Components\UserComponent::make([
        'name' => 'Peter Stovka',
        'email' => 'ps@stacktrace.sk',
    ]);

    expect($user)->toBeInstanceOf(Fixtures\Components\UserComponent::class);
});

test('component should inherit from model', function () {
    $clazz = new class extends \Insight\Inertia\View\Component {};

    expect($clazz::make())->toBeInstanceOf(\Insight\Inertia\View\Model::class);
});

it('should serialize component', function () {
    $user = Fixtures\Components\UserComponent::make([
        'name' => 'Peter Stovka',
        'email' => 'ps@stacktrace.sk',
    ]);

    expect($user->toInertia())->toMatchArray([
        'name' => 'Peter Stovka',
        'email' => 'ps@stacktrace.sk',
        'avatarUrl' => null,
        '_component' => [
            'name' => 'surface-user-component',
        ],
    ]);
});

it('should create component name', function ($namespace, $path, $result) {
    expect(new \Insight\Inertia\ResolvedComponent('test', $namespace, $path))->getName()->toBe($result);
})->with([
    ['app', 'Users', 'app-users'],
    ['app', 'Customer/Profile', 'app-customer-profile'],
    ['app', 'Customer/Profile/User', 'app-customer-profile-user'],
    ['surface', 'Customer/Profile/User', 'surface-customer-profile-user'],
    ['TEST', 'Customer', 'TEST-customer'],
]);
