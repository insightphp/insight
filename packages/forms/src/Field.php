<?php


namespace Insight\Forms;


use Closure;
use Illuminate\Support\Traits\ForwardsCalls;
use Insight\Inertia\View\Component;

class Field
{
    use ForwardsCalls;

    /**
     * The view component used to render the field.
     *
     * @var \Insight\Inertia\View\Component|\Closure|null
     */
    protected Component|Closure|null $component = null;

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
     * @param \Insight\Inertia\View\Component|\Closure $component
     * @return $this
     */
    public function withComponent(Component|Closure $component): static
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Resolves view component that is going to be rendered for the field.
     *
     * @return \Insight\Inertia\View\Component
     */
    public function resolveViewComponent(): Component
    {
        if ($this->component instanceof Component) {
            return $this->component;
        }

        if ($this->component instanceof Closure) {
            return call_user_func($this->component, $this);
        }

        throw new \RuntimeException("Component is not defined for the form field " . get_class($this));
    }

    public function __call(string $name, array $arguments)
    {
        // If the method does not exist on the field we'll forward it to the view component.
        if (! method_exists($this, $name)) {
            $this->forwardCallTo($this->component, $name, $arguments);

            return $this;
        }

        return $this->forwardCallTo($this, $name, $arguments);
    }

    /**
     * Creates new field for given control.
     *
     * @param \Insight\Inertia\View\Component $component
     * @return static
     */
    public static function for(Component $component): static
    {
        return (new static())->withComponent($component);
    }
}
