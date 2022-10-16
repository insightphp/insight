<?php


namespace Insight\Support;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Heroicons
{
    protected array $icons = [];

    /**
     * Register used icon.
     *
     * @param string $icon
     * @param int $size
     * @param string $style
     * @return $this
     */
    public function use(string $icon, int $size, string $style): static
    {
        $fullName = "{$icon}-{$size}-{$style}";

        if (! Arr::has($this->icons, $fullName)) {
            $this->icons[$fullName] = $this->resolveIcon($icon, $size, $style);
        }

        return $this;
    }

    /**
     * Retrieve list of used icons within the request.
     *
     * @return array
     */
    public function used(): array
    {
        return $this->icons;
    }

    protected function resolveIcon(string $name, int $size, string $style): string
    {
        $path = __DIR__ . '/../../resources/icons/heroicons/' . $size . '/' . $style . '/' . $name . '.svg';

        if (! file_exists($path)) {
            throw new \LogicException("The icon [$name] with size [$size] and style [$style] does not exist.");
        }

        return Str::of(file_get_contents($path))
            ->replaceMatches('/^\s+/m', '')
            ->replaceMatches('/\n/', '');
    }
}
