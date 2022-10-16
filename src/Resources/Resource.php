<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Insight\Resources\Concerns\AuthorizesActions;
use Insight\Resources\Concerns\CanBeEdited;
use Insight\Resources\Concerns\CanBeViewed;
use Insight\Resources\Concerns\CreatesDialogs;
use Insight\Resources\Concerns\CanBeListed;
use Insight\Resources\Concerns\CreatesLinks;
use Insight\Resources\Concerns\Searchable;
use Insight\Resources\Concerns\Filterable as IsFilterable;

class Resource
{
    use Searchable;
    use IsFilterable;
    use AuthorizesActions;
    use CreatesLinks;
    use CanBeListed;
    use CanBeViewed;
    use CanBeEdited;
    use CreatesDialogs;

    /**
     * The underlying Eloquent model for the resource.
     *
     * @var string
     */
    protected static string $model;

    /**
     * The title attribute of the resource.
     *
     * @var string|null
     */
    protected static ?string $title = null;

    /**
     * Retrieve the class of the underlying Eloquent model.
     *
     * @return string
     */
    public function getModelClass(): string
    {
        return static::$model;
    }

    /**
     * Retrieve the resource short name.
     * Usually class base name.
     *
     * @return string
     */
    public function getResourceShortName(): string
    {
        return substr(strrchr(static::class, '\\'), 1);
    }

    /**
     * Retrieve the resource long name.
     * Usually class FQCN.
     *
     * @return string
     */
    public function getResourceLongName(): string
    {
        return static::class;
    }

    /**
     * Retrieve the resource display name.
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return Str::singular(Str::headline($this->getResourceShortName()));
    }

    /**
     * Retrieve pluralized version of the display name.
     *
     * @return string
     */
    public function getDisplayPluralName(): string
    {
        return Str::plural($this->getDisplayName());
    }

    /**
     * Retrieve title of the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    public function title(Model $model): string
    {
        $titleAttribute = static::$title;

        if ($titleAttribute != null) {
            return $model->$titleAttribute;
        }

        throw new \LogicException("The title is not set for the resource [" . static::class . "]");
    }

    /**
     * Create new Eloquent model instance for the Resource.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newModel(): Model
    {
        $clazz = $this->getModelClass();

        return new $clazz;
    }

    /**
     * Create new Eloquent query builder for the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery(): Builder
    {
        return $this->newModel()->newQuery();
    }

    /**
     * Retrieve collection of resource fields.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFieldCollection(): Collection
    {
        if (! method_exists($this, 'fields')) {
            return collect();
        }

        $fields = $this->fields();

        if (is_array($fields)) {
            return collect($fields);
        }

        return collect();
    }

    /**
     * Retrieve the routing key for the resource.
     *
     * @return string
     */
    public function routingKey(): string
    {
        return Str::kebab(Str::plural($this->getResourceShortName()));
    }

    /**
     * Determine if resource supports soft deletes.
     *
     * @return bool
     */
    public function supportsSoftDeletes(): bool
    {
        return in_array(SoftDeletes::class, class_uses($this->getModelClass()));
    }
}
