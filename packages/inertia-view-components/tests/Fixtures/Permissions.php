<?php


namespace Insight\Inertia\Tests\Fixtures;


use Insight\Inertia\View\Model;

class Permissions extends Model
{
    public bool $view = true;

    public bool $delete = false;
}
