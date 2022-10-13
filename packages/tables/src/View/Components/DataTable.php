<?php


namespace Insight\Tables\View\Components;


use Illuminate\Support\Collection;
use Insight\Inertia\Support\ListOf;
use Insight\Inertia\View\Component;
use Insight\Tables\View\Models\PaginationLink;

class DataTable extends Table
{
    /**
     * The title of the table.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * The subtitle of the table.
     *
     * @var string|null
     */
    public ?string $subtitle = null;

    /**
     * Total items in the table.
     *
     * @var int|null
     */
    public ?int $totalItems = null;

    /**
     * Actions in the header.
     *
     * @var \Insight\Inertia\View\Component|null
     */
    public ?Component $headerActions = null;

    /**
     * Pagination links for the table.
     *
     * @var array
     */
    #[ListOf(PaginationLink::class)]
    public array $paginationLinks = [];

    /**
     * Add links from pagination links.
     *
     * @param \Illuminate\Support\Collection $links
     * @return $this
     */
    public function addPaginationLinks(Collection $links): static
    {
        $links->each(function (array $link, $index) use ($links) {
            $paginationLink = PaginationLink::fromPaginationLink($link);

            if ($index == 0) {
                $paginationLink->asPrevious();
            }

            if ($links->count() == $index + 1) {
                $paginationLink->asNext();
            }

            $this->paginationLinks[] = $paginationLink;
        });

        return $this;
    }
}
