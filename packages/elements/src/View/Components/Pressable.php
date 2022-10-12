<?php


namespace Insight\Elements\View\Components;


use Insight\Inertia\View\Component;

class Pressable extends Component
{
    /**
     * The content which is pressable.
     *
     * @var \Insight\Inertia\View\Component
     */
    public Component $content;

    /**
     * The color of the pressable.
     *
     * @var string
     */
    public string $type = 'primary';

    public function danger(): static
    {
        $this->type = 'danger';

        return $this;
    }

    public function primary(): static
    {
        $this->type = 'primary';

        return $this;
    }

    public function success(): static
    {
        $this->type = 'success';

        return $this;
    }

    /**
     * Create new pressable element.
     *
     * @param \Insight\Inertia\View\Component $component
     * @return static
     */
    public static function for(Component $component): static
    {
        return static::make(['content' => $component]);
    }
}
