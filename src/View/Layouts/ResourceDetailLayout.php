<?php


namespace Insight\View\Layouts;


use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Link;
use Insight\Inertia\View\Component;
use Insight\Resources\Resource;

class ResourceDetailLayout extends Component
{
    /**
     * The title of the resource.
     *
     * @var string
     */
    public string $title;

    /**
     * The link to the list of resources.
     *
     * @var \Insight\Elements\View\Components\Link|null
     */
    public ?Link $listResourcesLink = null;

    /**
     * Determine if the resource is deleted.
     *
     * @var bool
     */
    public bool $trashed = false;

    public function __construct(
        protected Resource $resource,
        protected Model $model
    )
    {
        $this->title = $this->resource->title($this->model);

        if ($this->resource->canViewAnyResources()) {
            $links = $this->resource->createLinks($this->model);

            $this->listResourcesLink = Link::toLocation(
                $this->resource->getDisplayPluralName(),
                $links->index()
            );
        }

        $this->trashed = $this->resource->supportsSoftDeletes() && $this->model->trashed();
    }
}
