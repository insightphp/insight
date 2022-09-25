<?php


namespace Insight\Inertia\Contracts;


use Insight\Inertia\View\Component;

interface Renderable
{
    /**
     * Returns component which renders the object.
     *
     * @return \Insight\Inertia\View\Component
     */
    public function toComponent(): Component;
}
