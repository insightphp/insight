<?php


namespace Insight\Inertia\Support;


use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ListOf
{
    public function __construct(public string $type) {}
}
