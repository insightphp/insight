<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Insight\Elements\View\Components\Button;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Stack;
use Insight\Inertia\View\Component;
use Insight\Panels\View\Components\Panel;
use Insight\Panels\View\Components\PanelRow;
use Insight\View\Components\Menu;
use Insight\View\Models\Navigation;
use Insight\View\Models\NavigationItem;

class PanelFactory
{
    public function __construct(
        protected Resource $resource,
        protected Model $model
    ) {}

    protected function toPanelRow(Field $field): Component
    {
        $value = $field->createPanelField($this->resource, $this->model);

        $label = $field->getPanelLabel();

        return PanelRow::make([
            'title' => $label,
            'value' => $value,
        ]);
    }

    protected function resolvePanelItems(Collection $fields): Collection
    {
        return $fields->map(fn (Field $field) => $this->toPanelRow($field));
    }

    protected function resolveMorePanelActions(Collection $fields): ?Component
    {
        $navigation = Navigation::make();

        if ($this->resource->supportsSoftDeletes() && $this->model->trashed()) {
            if ($this->resource->canRestoreResource($this->model)) {
                $navigation->add(NavigationItem::for(
                    Link::toDialog('Restore', 'restore-resource', [
                        'resource' => $this->model->getRouteKey(),
                    ])
                ));
            }

            if ($this->resource->canForceDeleteResource($this->model)) {
                $navigation->add(NavigationItem::for(
                    Link::toDialog('Force Delete', 'destroy-resources', [
                        'resources' => [$this->model->getRouteKey()],
                        'force' => true,
                    ])
                ));
            }
        } else if ($this->resource->canDeleteResource($this->model)) {
            $navigation->add(NavigationItem::for(
                Link::toDialog('Delete', 'destroy-resources', [
                    'resources' => [$this->model->getRouteKey()],
                ])
            ));
        }

        if ($navigation->isEmpty()) {
            return null;
        }

        return Menu::withNavigation($navigation)
            ->withToggle(Button::withText('More', 'ellipsis-horizontal'));
    }

    protected function resolvePanelActions(Collection $fields): ?Component
    {
        $actions = Stack::make()->gap(3);

        $links = $this->resource->createLinks($this->model);

        // Actions dropdown
        $moreActions = $this->resolveMorePanelActions($fields);
        if ($moreActions instanceof Component) {
            $actions->add($moreActions);
        }

        // Edit link
        if ($this->resource->canUpdateResource($this->model)) {
            $actions->add(
                Link::toLocation('Edit', $links->edit())
                    ->asButton('primary', 'pencil')
            );
        }

        return $actions->isEmpty() ? null : $actions;
    }

    /**
     * Create new details panel.
     *
     * @return \Insight\Panels\View\Components\Panel
     */
    public function getDetailsPanel(): Panel
    {
        $fields = $this->resource->getFieldCollection()->filter(function (Field $field) {
            return $field->hasPanelField() && $field->isVisibleOnDetail($this->resource, $this->model);
        });

        $panel = Panel::make([
            'title' => $this->resource->getTitleForDetailPanel($this->model),
            'actions' => $this->resolvePanelActions($fields),
        ]);

        $items = $this->resolvePanelItems($fields);

        if ($items->isNotEmpty()) {
            $panel->items = $items->all();
        }

        return $panel;
    }
}
