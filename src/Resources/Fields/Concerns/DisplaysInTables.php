<?php


namespace Insight\Resources\Fields\Concerns;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Component;
use Insight\Resources\Resource;

/**
 * @mixin \Insight\Resources\Field
 */
trait DisplaysInTables
{
    /**
     * Custom column for sorting.
     *
     * @var string|null
     */
    protected ?string $sortableAs = null;

    /**
     * Custom factory for table field.
     *
     * @var \Closure|null
     */
    protected ?\Closure $createTableFieldUsing = null;

    /**
     * Determine if the field is displayable in the table.
     *
     * @return bool
     */
    public function hasTableField(): bool
    {
        return method_exists($this, 'resolveTableField');
    }

    /**
     * Creates new table field.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Insight\Inertia\View\Component|null
     */
    public function createTableField(Resource $resource, Model $model): ?Component
    {
        if ($this->createTableFieldUsing instanceof \Closure) {
            return value($this->createTableFieldUsing, $resource, $model, $this);
        }

        if ($this->hasTableField()) {
            return $this->resolveTableField($resource, $model);
        }

        return null;
    }

    /**
     * Set custom factory for table field.
     *
     * @param \Closure $factory
     * @return $this
     */
    public function createTableFieldUsing(\Closure $factory): static
    {
        $this->createTableFieldUsing = $factory;

        return $this;
    }

    /**
     * Retrieve title for table column.
     *
     * @return string
     */
    public function getTitleForTableColumn(): string
    {
        return $this->getTitle();
    }

    /**
     * Set field as sortable.
     *
     * @param string|null $sortableAs
     * @return $this
     */
    public function sortable(?string $sortableAs = null): static
    {
        if ($sortableAs != null) {
            $this->sortableAs = $sortableAs;
        } else {
            $this->sortableAs = $this->getAttributeName();
        }

        return $this;
    }

    /**
     * Determine if the field is sortable.
     *
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortableAs != null;
    }

    /**
     * Retrieve the column under which the field is sortable.
     *
     * @return string|null
     */
    public function getSortableAs(): ?string
    {
        return $this->sortableAs;
    }
}
