<?php


namespace Insight\Inertia\Contracts;


interface HasInertiaProps
{
    /**
     * Retrieve array of attributes which are passed to Inertia.
     *
     * @return array|\Closure|null
     */
    public function toInertia(): array|\Closure|null;
}
