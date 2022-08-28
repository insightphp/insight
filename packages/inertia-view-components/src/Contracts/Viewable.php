<?php


namespace Insight\Inertia\Contracts;


use Insight\Inertia\ViewComponent;

interface Viewable
{
    /**
     * Retrieves the view component of the viewable.
     *
     * @return \Insight\Inertia\ViewComponent
     */
    public function toView(): ViewComponent;
}
