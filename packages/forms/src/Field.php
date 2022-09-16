<?php


namespace Insight\Forms;


use Closure;
use Illuminate\Support\Traits\ForwardsCalls;
use Insight\Inertia\Contracts\Viewable;
use Insight\Inertia\ViewComponent;

class Field implements Viewable
{
    use ForwardsCalls;

    /**
     * Array of pending configurations on the view.
     *
     * @var array
     */
    protected array $pendingConfigurations = [];

    /**
     * Add pending configuration on the view.
     *
     * @param \Closure $closure
     * @return $this
     */
    protected function apply(Closure $closure): static
    {
        $this->pendingConfigurations[] = $closure;

        return $this;
    }

    /**
     * The view component which is rendered for the field.
     *
     * @var \Insight\Inertia\ViewComponent|\Closure|null
     */
    protected ViewComponent|Closure|null $component = null;

    /**
     * Retrieves empty value of the field.
     *
     * @return mixed
     */
    public function getEmptyValue(): mixed
    {
        return null;
    }

    /**
     * Set the view component for the field.
     *
     * @param \Closure|\Insight\Inertia\ViewComponent $component
     * @return $this
     */
    public function useViewComponent(Closure|ViewComponent $component): static
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Resolves view component that is going to be rendered for the field.
     *
     * @return \Insight\Inertia\ViewComponent
     */
    public function resolveViewComponent(): ViewComponent
    {
        if ($this->component instanceof ViewComponent) {
            return $this->component;
        }

        if ($this->component instanceof Closure) {
            return call_user_func($this->component, $this);
        }

        throw new \RuntimeException("View Component is not defined for the form field " . get_class($this));
    }

    /**
     * Configures view component with pending configurations.
     *
     * @param \Insight\Inertia\ViewComponent $component
     * @return \Insight\Inertia\ViewComponent
     */
    protected function withConfigurationsOn(ViewComponent $component): ViewComponent
    {
        foreach ($this->pendingConfigurations as $configuration) {
            call_user_func($configuration, $component);
        }

        return $component;
    }

    public function toView(): ViewComponent
    {
        return $this->resolveViewComponent();
    }

    public function __call(string $name, array $arguments)
    {
        // If the method does not exist on the field
        // we'll forward it to the view component.
        if (! method_exists($this, $name)) {
            return $this->apply(fn ($field) => $this->forwardCallTo($field, $name, $arguments));
        }

        return $this->forwardCallTo($this, $name, $arguments);
    }

    /**
     * Creates new instance of the field.
     *
     * @param mixed ...$args
     * @return static
     */
    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
