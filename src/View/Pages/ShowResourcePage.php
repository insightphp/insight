<?php


namespace Insight\View\Pages;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Component;
use Insight\Resources\Resource;

class ShowResourcePage extends InsightPage
{
    protected ?string $page = 'insight:ShowResourcePage';

    /**
     * The details panel of the resource.
     *
     * @var \Insight\Panels\View\Components\Panel|null
     */
    public ?Component $details = null;

    public function __construct(
        protected Resource $resource,
        protected Model $model
    )
    {
        $panelFactory = $this->resource->newPanel($this->model);

        $this->details = $panelFactory->getDetailsPanel();

        $layout = $this->resource->createDetailLayout($this->model);
        if ($layout instanceof Component) {
            $this->layout($layout);
        }

        $this->dialogs($this->resource->getDialogsForDetail());
    }
}
