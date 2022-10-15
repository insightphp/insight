<?php


namespace Insight\Elements\View\Components;


use Insight\Inertia\View\Component;

class Stack extends Component
{
    /**
     * Items of the stack.
     *
     * @var array
     */
    public array $items = [];

    /**
     * The orientation of the stack.
     *
     * @var string
     */
    public string $orientation = 'horizontal';

    /**
     * The gap between items in the stack.
     *
     * @var string
     */
    public string $gap = 'gap-1';

    /**
     * The content alignment.
     *
     * @var string
     */
    public string $align = 'center';

    /**
     * Set the content alignment.
     *
     * @param string $align
     * @return $this
     */
    public function align(string $align): static
    {
        $this->align = $align;

        return $this;
    }

    /**
     * Align items to the center.
     *
     * @return $this
     */
    public function center(): static
    {
        return $this->align('center');
    }

    /**
     * Align items to the top.
     *
     * @return $this
     */
    public function top(): static
    {
        return $this->align('top');
    }

    /**
     * Align items to the bottom.
     *
     * @return $this
     */
    public function bottom(): static
    {
        return $this->align('bottom');
    }

    /**
     * Display items horizontaly.
     *
     * @return $this
     */
    public function horizontal(): static
    {
        $this->orientation = 'horizontal';

        return $this;
    }

    /**
     * Display items verticaly.
     *
     * @return $this
     */
    public function vertical(): static
    {
        $this->orientation = 'vertical';

        return $this;
    }

    /**
     * Display items in a row.
     *
     * @return $this
     */
    public function row(): static
    {
        return $this->horizontal();
    }

    /**
     * Display items in column.
     *
     * @return $this
     */
    public function column(): static
    {
        return $this->vertical();
    }

    /**
     * Add components to the stack.
     *
     * @param \Insight\Inertia\View\Component ...$item
     * @return $this
     */
    public function add(Component ...$item): static
    {
        foreach ($item as $component) {
            $this->items[] = $component;
        }

        return $this;
    }

    /**
     * Set the gap between items in the stack.
     *
     * @param string|int $gap
     * @return $this
     */
    public function gap(string|int $gap): static
    {
        if (is_numeric($gap)) {
            $this->gap = "gap-{$gap}";
        } else {
            $this->gap = $gap;
        }

        return $this;
    }

    /**
     * Determines if the stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Create stack of items.
     *
     * @param array $items
     * @return static
     */
    public static function of(array $items): static
    {
        return static::make(['items' => $items]);
    }
}
