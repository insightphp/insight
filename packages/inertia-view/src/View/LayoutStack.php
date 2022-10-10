<?php


namespace Insight\Inertia\View;


class LayoutStack
{
    /**
     * Arranged layouts in the stack.
     *
     * @var array
     */
    protected array $layouts = [];

    /**
     * Add layout to the stack.
     *
     * @param \Insight\Inertia\View\Component $layout
     * @return $this
     */
    public function add(Component $layout): static
    {
        $this->layouts[] = $layout;

        return $this;
    }

    /**
     * Retrieve layouts in the stack.
     *
     * @return array
     */
    public function getLayouts(): array
    {
        return $this->layouts;
    }

    /**
     * Determines if the layout stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->layouts);
    }

    /**
     * Add layouts from differnet layout stack.
     *
     * @param \Insight\Inertia\View\LayoutStack $stack
     * @return $this
     */
    public function addFrom(LayoutStack $stack): static
    {
        foreach ($stack->getLayouts() as $layout) {
            $this->add($layout);
        }

        return $this;
    }
}
