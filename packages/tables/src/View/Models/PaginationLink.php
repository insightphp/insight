<?php


namespace Insight\Tables\View\Models;


use Illuminate\Support\Arr;
use Insight\Inertia\View\Model;

class PaginationLink extends Model
{
    /**
     * The url of the link.
     *
     * @var string|null
     */
    public ?string $url = null;

    /**
     * The title of the link.
     *
     * @var string
     */
    public string $title;

    /**
     * Determina if the pagination link is active.
     *
     * @var bool
     */
    public bool $active;

    /**
     * The type of the link.
     *
     * @var string
     */
    public string $type = 'page';

    /**
     * Set the link type as previous.
     *
     * @return $this
     */
    public function asPrevious(): static
    {
        $this->type = 'prev';

        return $this;
    }

    /**
     * Set the link type as next.
     *
     * @return $this
     */
    public function asNext(): static
    {
        $this->type = 'next';

        return $this;
    }

    /**
     * Create new link from Illuminate pagination link.
     *
     * @param array $link
     * @return static
     */
    public static function fromPaginationLink(array $link): static
    {
        return static::make([
            'url' => Arr::get($link, 'url'),
            'title' => Arr::get($link, 'label'),
            'active' => Arr::get($link, 'active', false),
        ]);
    }
}
