<?php


namespace Insight\Inertia\Tests\Fixtures;


use Insight\Inertia\View\Page;

class ProfilePage extends Page
{
    protected ?string $page = 'Pages/Profile';

    /**
     * The name of the user.
     *
     * @var string
     */
    public string $name;
}
