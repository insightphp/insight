<?php


namespace Insight\Inertia\Contracts;


use Insight\Inertia\ViewComponent;

/**
 * @deprecated
 */
interface Viewable
{
    /**
     * Retrieves the view component of the viewable.
     *
     * @return \Insight\Inertia\ViewComponent
     */
    public function toView(): ViewComponent;
}
