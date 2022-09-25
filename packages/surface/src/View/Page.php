<?php


namespace Insight\Inertia\View;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Arr;
use Inertia\ResponseFactory;
use Insight\Inertia\Exceptions\ViewException;

class Page extends Model implements Responsable
{
    /**
     * The underlaying component for the page.
     *
     * @var string|null
     */
    protected ?string $page = null;

    /**
     * Custom attributes of the page.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Add attribute to the page.
     *
     * @param string|array $key
     * @param mixed|null $value
     * @return $this
     */
    public function with(string|array $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->attributes = array_merge($this->attributes, $key);
        } else if ($key instanceof Arrayable) {
            $this->attributes = array_merge($this->attributes, $key->toArray());
        } else {
            Arr::set($this->attributes, $key, $value);
        }

        return $this;
    }

    /**
     * Set page component for the page.
     *
     * @param string $component
     * @return $this
     */
    public function usePage(string $component): static
    {
        $this->page = $component;

        return $this;
    }

    /**
     * Resolve the page component.
     *
     * @return string
     */
    public function resolvePageComponent(): string
    {
        if (is_null($this->page)) {
            throw new ViewException("The component for the page [".static::class."] is not defined.");
        }

        return $this->page;
    }

    /**
     * Retrieve response data which should be sent to Inertia.
     *
     * @return array
     */
    public function resolvePageData(): array
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), $this->prepareForInertia($this->attributes));
    }

    public function toResponse($request)
    {
        return app(ResponseFactory::class)
            ->render($this->resolvePageComponent(), $this->resolvePageData())
            ->toResponse($request);
    }

    /**
     * Creates new page using given component and attributes.
     *
     * @param string $component
     * @param array $attributes
     * @return static
     */
    public static function render(string $component, array $attributes = []): static
    {
        return static::make($attributes)->usePage($component);
    }

    /**
     * Creates new page instance.
     *
     * @param array $attributes
     * @return static
     */
    public static function make(array $attributes = []): static
    {
        return parent::make(Arr::except($attributes, ['page', 'attributes']));
    }
}
