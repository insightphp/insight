<?php


namespace Insight\View\Models;


use Closure;
use Illuminate\Support\Collection;
use Insight\Inertia\View\Model;

class Navigation extends Model
{
    /**
     * List of items within navigation.
     *
     * @var array<\Insight\View\Models\NavigationItem>
     */
    public array $items = [];

    /**
     * Add item to the navigation.
     *
     * @param \Closure|\Insight\View\Models\NavigationItem $item
     * @return $this
     */
    public function add(Closure|NavigationItem $item): static
    {
        $this->items[] = value($item);

        return $this;
    }

    /**
     * Add item to the navigation when the condition is truthy.
     *
     * @param \Closure|bool $when
     * @param \Closure|\Insight\View\Models\NavigationItem $item
     * @return $this
     */
    public function addWhen(Closure|bool $when, Closure|NavigationItem $item): static
    {
        return value($when) ? $this->add($item) : $this;
    }

    /**
     * Add item to the navigation when the condition is falsy.
     *
     * @param \Closure|bool $when
     * @param \Closure|\Insight\View\Models\Navigation $item
     * @return $this
     */
    public function addUnless(Closure|bool $when, Closure|Navigation $item): static
    {
        return value($when) ? $this : $this->add($item);
    }

    /**
     * Determine if the navigation is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Retrieve collection of navigation items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function items(): Collection
    {
        return collect($this->items);
    }

    /**
     * Add items from other navigation.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return $this
     */
    public function mergeWith(Navigation $navigation): static
    {
        $navigation->items()->each(fn (NavigationItem $item) => $this->add($item));

        return $this;
    }
}
