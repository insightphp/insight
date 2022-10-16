<?php


namespace Insight\View\Layouts;


use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Text;
use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;
use Insight\Resources\Resource;
use Insight\View\Components\Heroicon;

class ResourceDetailLayout extends Component
{
    public function __construct(
        protected Resource $resource,
        protected Model    $model
    ) {}

    /**
     * Determine if the resource is deleted.
     *
     * @return bool
     */
    #[Computed]
    public function trashed(): bool
    {
        return $this->resource->supportsSoftDeletes() && $this->model->trashed();
    }

    /**
     * The title of the resource.
     *
     * @return string
     */
    #[Computed]
    public function title(): string
    {
        return $this->resource->title($this->model);
    }

    /**
     * Items of the breadcrumb navigation.
     *
     * @return array
     */
    #[Computed]
    public function breadcrumbItems(): array
    {
        $items = [
            Heroicon::outline('home'),
        ];

        if ($this->resource->canViewAnyResources()) {
            $links = $this->resource->createLinks($this->model);

            $items[] = Link::toLocation(
                $this->resource->getDisplayPluralName(),
                $links->index()
            );
        }

        $items[] = Text::of($this->resource->title($this->model));

        return $items;
    }
}
