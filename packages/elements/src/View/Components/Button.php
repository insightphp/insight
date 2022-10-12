<?php


namespace Insight\Elements\View\Components;


use Insight\Inertia\View\Component;
use Insight\View\Components\Heroicon;

class Button extends Component
{
    /**
     * The type of the button.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * The content of the button.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $content = null;

    /**
     * Set the button look as primary.
     *
     * @return $this
     */
    public function primary(): static
    {
        $this->type = 'primary';

        return $this;
    }

    /**
     * Creates button with content.
     *
     * @param \Insight\Inertia\View\Component $component
     * @return static
     */
    public static function withContent(Component $component): static
    {
        return static::make(['content' => $component]);
    }

    /**
     * Create button with title and icon.
     *
     * @param string $text
     * @param string|null $icon
     * @param int $iconSize
     * @param string $iconStyle
     * @return static
     */
    public static function withText(string $text, ?string $icon = null, int $iconSize = 24, string $iconStyle = 'outline'): static
    {
        $content = [];

        if ($icon) {
            $content[] = Heroicon::for($icon, $iconSize, $iconStyle);
        }

        $content[] = Text::of($text);

        return static::withContent(Stack::of($content)->gap(2));
    }
}
