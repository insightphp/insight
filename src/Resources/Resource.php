<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Insight\Elements\View\Components\Link;
use Insight\Resources\Concerns\Searchable;
use Insight\View\Models\NavigationItem;
use Insight\View\Pages\ListResourcesPage;

class Resource
{
    use Searchable;

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
     * Determine if the resources should be visible in navigation.
     *
     * @var bool
     */
    protected bool $shouldShowInNavigation = true;

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
     * Retrieve the routing key for the resource.
     *
     * @return string
     */
    public function routingKey(): string
    {
        return Str::kebab(Str::plural($this->getResourceShortName()));
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
     * Create new Eloquent query for index.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newIndexQuery(): Builder
    {
        return $this->newQuery();
    }

    /**
     * Determine if the resource should be displayed in navigation.
     *
     * @return bool
     */
    public function shouldShowInNavigation(): bool
    {
        return $this->shouldShowInNavigation;
    }

    /**
     * Retrieve link generator for the resources.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return \Insight\Resources\ResourceLinks
     */
    public function createLinks(?Model $model = null): ResourceLinks
    {
        return new ResourceLinks($this, $model);
    }

    /**
     * Create navigation item for the Resource.
     *
     * @return \Insight\View\Models\NavigationItem
     */
    public function createNavigationItem(): NavigationItem
    {
        $links = $this->createLinks();

        $link = Link::make([
            'title' => $this->getDisplayPluralName(),
            'location' => $links->index(),
        ]);

        foreach ($links->getActivationRoutes() as $routeName => $params) {
            $link->activatedOnRoute($routeName, $params);
        }

        return NavigationItem::for($link);
    }

    /**
     * Creates new table factory for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Insight\Resources\TableFactory
     */
    public function newTable(Request $request): TableFactory
    {
        return new TableFactory($request, $this);
    }

    /**
     * Retrieve the table name.
     *
     * @return string
     */
    public function getTitleForTable(): string
    {
        return $this->getDisplayPluralName();
    }

    /**
     * The default sorting for the resource.
     *
     * @return \Insight\Resources\Sorting|null
     */
    public function getDefaultSorting(): ?Sorting
    {
        return Sorting::desc('id');
    }

    /**
     * Retrieve collection of resource fields.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFields(): Collection
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
     * Retrieve list of fields which can be displayed on the table.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTableFields(): Collection
    {
        return $this->getFields()->filter(function (Field $field) {
            return $field->hasTableField();
        });
    }

    /**
     * Retrieve the model identifier.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function getIdentifier(Model $model): mixed
    {
        return $model->getKey();
    }

    /**
     * Retrieve the routing identifier for the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function getRoutingIdentifier(Model $model): mixed
    {
        return $model->getRouteKey();
    }

    /**
     * Create new index page for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Insight\View\Pages\ListResourcesPage
     */
    public function toIndexPage(Request $request): ListResourcesPage
    {
        return new ListResourcesPage($request, $this);
    }
}
