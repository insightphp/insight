<?php


namespace Insight\View\Pages;


use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Text;
use Insight\Inertia\Support\Computed;
use Insight\Resources\Resource;
use Insight\View\Components\Heroicon;

class ResourceFormPage extends InsightPage
{
    protected ?string $page = 'insight:ResourceFormPage';

    public function __construct(
        protected Resource $resource,
        protected ?Model $model = null
    )
    {
        //
    }

    /**
     * The items for the breadcrumb.
     *
     * @return array
     */
    #[Computed]
    public function breadcrumbItems(): array
    {
        $items = [Heroicon::outline('home')];

        if ($this->resource->canViewAnyResources()) {
            $links = $this->resource->createLinks();

            $items[] = Link::toLocation($this->resource->getDisplayPluralName(), $links->index());
        }

        if ($this->isEdit()) {
            $links = $this->resource->createLinks($this->model);

            if ($this->resource->canViewResource($this->model)) {
                $items[] = Link::toLocation($this->resource->title($this->model), $links->show());
            }
        }

        $items[] = Text::of($this->getPageTitle());

        return $items;
    }

    /**
     * Retrieve the page title.
     *
     * @return string
     */
    #[Computed(name: 'title')]
    public function getPageTitle(): string
    {
        if ($this->isEdit()) {
            return "Edit {$this->resource->getDisplayName()}";
        }

        return "Create {$this->resource->getDisplayName()}";
    }

    /**
     * Determine if the page is for editing the resource.
     *
     * @return bool
     */
    #[Computed(name: 'edit')]
    public function isEdit(): bool
    {
        return $this->model != null;
    }
}
