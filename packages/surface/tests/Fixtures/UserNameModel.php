<?php


namespace Insight\Inertia\Tests\Fixtures;


use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Model;

class UserNameModel extends Model
{
    protected string $firstName;

    protected string $lastName;

    #[Computed]
    public function fullName(): string
    {
        return $this->getFullName();
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
