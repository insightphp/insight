<?php

use Insight\Inertia\Tests\Fixtures;
use Insight\Inertia\View\Model;

test('it should create model', function () {
    $model = Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
        'email' => 'ps@stacktrace.sk',
    ]);

    expect($model)->toBeInstanceOf(Fixtures\UserModel::class);
});

test('it should return model attribute', function () {
    $model = Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
        'email' => 'ps@stacktrace.sk',
    ]);

    expect($model->name)->toBe('Peter Stovka')->and($model->email)->toBe('ps@stacktrace.sk');
});

test('it should return null when attribute is nullable and was not set', function () {
    $model = Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
    ]);

    expect($model->name)->toBe('Peter Stovka')->and($model->email)->toBeNull();
});

test('it should return default value of nullable attribute when it was not set', function () {
    $model = Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
    ]);

    expect($model->id)->toBe(1);
});

test('it should throw AttributeNotSetException when required attribute is missing during construction', function () {
    Fixtures\UserModel::make();
})->throws(\Insight\Inertia\Exceptions\AttributeNotSetException::class, 'The model attribute [name] does not have any value.');

test('it should AttributeNotSetException when required protected property is not set', function () {
    $model = new class extends Model {
        protected string $name;
    };

    $model::make();
})->throws(\Insight\Inertia\Exceptions\AttributeNotSetException::class, "The model attribute [name] does not have any value.");

test('it should throw MissingAttributeException when setting attribute which is not deffined', function () {
    Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
        'age' => 25,
    ]);
})->throws(\Insight\Inertia\Exceptions\MissingAttributeException::class, "The model attribute [age] does not exist on model [" . Fixtures\UserModel::class . "].");

test('it should set protected property on the model', function () {
    $model = Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
        'password' => 'secret',
    ]);

    expect($model->getPassword())->toBe('secret');
});

test('it should serialize model to inertia', function () {
    $model = Fixtures\UserModel::make([
        'name' => 'Peter Stovka',
    ]);

    expect($model->toInertia())->toMatchArray([
        'id' => 1,
        'name' => 'Peter Stovka',
        'email' => null,
    ]);
});

test('it should not serialize protected or private properties', function () {
    $clazz = new class extends Model {
        public string $name;
        protected string $password;
        private string $rememberToken = 'very secret token';
    };

    expect($clazz::make([
        'name' => 'Peter',
        'password' => 'secret',
    ]))->not()->toHaveKeys(['password', 'rememberToken']);
});

test('it should serialized array', function () {
    $model = new class extends Model {
        public array $permissions;
    };

    expect($model::make(['permissions' => ['view', 'delete']])->toInertia())->toMatchArray(['permissions' => ['view', 'delete']]);
});

test('it should serialize associative array', function () {
    $model = new class extends Model {
        public array $permissions;
    };

    expect($model::make(['permissions' => ['view' => true, 'delete' => false]])->toInertia())
        ->toMatchArray(['permissions' => ['view' => true, 'delete' => false]]);
});

test('it should serialize view model within view model', function () {
    $model = new class extends Model {
        public Fixtures\PermissionsModel $permissions;
    };

    $permissions = Fixtures\PermissionsModel::make([
        'view' => true,
        'delete' => true,
    ]);

    expect($model::make(['permissions' => $permissions])->toInertia())
        ->toMatchArray(['permissions' => [ 'view' => true, 'delete' => true, ]]);
});

test('it should serialize collection of view models', function () {
    $model = new class extends Model {
        public array $permissions;
    };

    $permissions = [
        Fixtures\PermissionsModel::make(['view' => true, 'delete' => false]),
        Fixtures\PermissionsModel::make(['view' => false, 'delete' => true]),
    ];

    expect($model::make(['permissions' => $permissions])->toInertia())
        ->toMatchArray(['permissions' => [ ['view' => true, 'delete' => false], ['view' => false, 'delete' => true] ]]);
});

test('it should serialize associative array of view models', function () {
    $model = new class extends Model {
        public array $permissions;
    };

    $permissions = [
        'peter' => Fixtures\PermissionsModel::make(['view' => true, 'delete' => false]),
        'adriana' => Fixtures\PermissionsModel::make(['view' => false, 'delete' => true]),
    ];

    expect($model::make(['permissions' => $permissions])->toInertia())
        ->toMatchArray(['permissions' => [ 'peter' => ['view' => true, 'delete' => false], 'adriana' => ['view' => false, 'delete' => true] ]]);
});

test('it should serialize computed property', function () {
    $model = Fixtures\UserNameModel::make([
        'firstName' => 'Peter',
        'lastName' => 'Stovka',
    ]);

    expect($model->toInertia())
        ->toMatchArray(['fullName' => 'Peter Stovka'])
        ->not()->toHaveKeys(['firstName', 'lastName', 'getFullName']);
});

test('it should seriailze computed property with custom name', function () {
    $model = new class extends Model {
        protected string $firstName;
        protected string $lastName;

        #[\Insight\Inertia\Support\Computed(name: 'fullName')]
        public function getFullName(): string
        {
            return $this->firstName . ' ' . $this->lastName;
        }
    };

    expect($model::make(['firstName' => 'Peter', 'lastName' => 'Stovka'])->toInertia())
        ->toMatchArray(['fullName' => 'Peter Stovka'])
        ->not()->toHaveKeys(['firstName', 'lastName', 'getFullName']);
});
