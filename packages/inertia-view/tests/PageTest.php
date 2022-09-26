<?php

use Insight\Inertia\Tests\Fixtures;

it('should return response', function () {
    $page = Fixtures\ProfilePage::make([
        'name' => 'Peter Stovka',
    ]);

    expect($page->toResponse(request()))->toBeInstanceOf(\Illuminate\Http\Response::class);
});

it('should serialize page', function () {
    $page = Fixtures\ProfilePage::make([
        'name' => 'Peter Stovka',
    ]);

    expect($page->resolvePageData())->toMatchArray([
        'name' => 'Peter Stovka',
    ])->not()->toHaveKeys(['page', 'attributes']);
});

it('should resolve page component')
    ->expect(Fixtures\ProfilePage::make(['name' => 'Peter']))
    ->resolvePageComponent()
    ->toBe('Pages/Profile');

it('should resolve customized page component')
    ->expect(Fixtures\ProfilePage::make(['name' => 'Peter'])
    ->usePage('NewPages/Profile'))
    ->resolvePageComponent()
    ->toBe('NewPages/Profile');

it('should set custom attributes on page', function () {
    expect(Fixtures\ProfilePage::make(['name' => 'Peter']))
        ->with('email', 'ps@stacktrace.sk')
        ->resolvePageData()
        ->toBe([
            'name' => 'Peter',
            'email' => 'ps@stacktrace.sk',
        ]);
});

it('should ignore page or attributes properties when making page', function () {
    $page = Fixtures\ProfilePage::make([
        'name' => 'Peter Stovka',
        'page' => 'Another Page',
        'attributes' => [],
    ]);

    expect($page->resolvePageData())->toBe([
        'name' => 'Peter Stovka',
    ])->not()->toHaveKeys(['page', 'attributes']);
});
