<?php


namespace Insight\Resources\Fields\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Component;
use Insight\Resources\Resource;

trait DisplaysInPanels
{
    /**
     * Custom factory for panel field.
     *
     * @var \Closure|null
     */
    protected ?\Closure $createPanelFieldUsing = null;

    /**
     * Determine if the field is displayable in the panel.
     *
     * @return bool
     */
    public function hasPanelField(): bool
    {
        return method_exists($this, 'resolvePanelField');
    }

    /**
     * Create new panel field.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Inertia\View\Component|null
     */
    public function createPanelField(Resource $resource, Model $model): ?Component
    {
        if ($this->createPanelFieldUsing instanceof \Closure) {
            return value($this->createPanelFieldUsing, $resource, $model, $this);
        }

        if ($this->hasPanelField()) {
            return $this->resolvePanelField($resource, $model);
        }

        return null;
    }

    /**
     * Set custom factory for panel field.
     *
     * @param \Closure $factory
     * @return $this
     */
    public function createPanelFieldUsing(\Closure $factory): static
    {
        $this->createPanelFieldUsing = $factory;

        return $this;
    }
}
