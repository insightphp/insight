<?php


namespace Insight\View\Components;


use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;
use Insight\Support\Heroicons;

class Heroicon extends Component
{
    /**
     * The name of the icon.
     *
     * @var string
     */
    public string $name;

    /**
     * The icon size.
     *
     * @var int
     */
    public int $size = 24;

    /**
     * The style of the icon.
     *
     * @var string
     */
    public string $style = 'solid';

    /**
     * The dimensions of the icon.
     *
     * @var string
     */
    public string $dimensions = 'w-4 h-4';

    #[Computed]
    public function fullName(): string
    {
        return "{$this->name}-{$this->size}-{$this->style}";
    }

    /**
     * Set the icon dimensions.
     *
     * @param string|int $dimensions
     * @return $this
     */
    public function dimensions(string|int $dimensions): static
    {
        if (is_numeric($dimensions)) {
            $this->dimensions = "w-{$dimensions} h-{$dimensions}";
        } else {
            $this->dimensions = $dimensions;
        }

        return $this;
    }

    /**
     * Create new icon.
     *
     * @param string $name
     * @param int $size
     * @param string $style
     * @return static
     */
    public static function for(string $name, int $size = 24, string $style = 'solid'): static
    {
        return static::make(['name' => $name, 'size' => $size, 'style' => $style])->ensureUsed();
    }

    /**
     * Create new solid icon.
     *
     * @param string $name
     * @param int $size
     * @return static
     */
    public static function solid(string $name, int $size = 24): static
    {
        return static::for($name, $size);
    }

    /**
     * Create new outline icon.
     *
     * @param string $name
     * @return static
     */
    public static function outline(string $name): static
    {
        return static::for($name, 24, 'outline');
    }

    protected function ensureUsed(): static
    {
        app(Heroicons::class)->use($this->name, $this->size, $this->style);

        return $this;
    }
}
