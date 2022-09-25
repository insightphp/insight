<?php


namespace Insight\Inertia\Tests\Fixtures\Components;


use Insight\Inertia\View\Component;

class UserComponent extends Component
{
    public string $name;

    public string $email;

    public ?string $avatarUrl;
}
