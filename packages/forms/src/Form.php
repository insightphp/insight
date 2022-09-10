<?php


namespace Insight\Forms;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Insight\Forms\Concerns\ValidatesFormValue;
use Insight\Forms\Contracts\FormContext;

class Form
{
    use ValidatesFormValue;

    /**
     * Available controls on the form.
     *
     * @var array<\Insight\Forms\FormControl>
     */
    protected array $controls = [];

    /**
     * The URL where the form should be submitted.
     *
     * @var string|null
     */
    protected ?string $action = null;

    /**
     * HTTP method used to submit the form.
     *
     * @var string
     */
    protected string $method = 'post';

    /**
     * Determine if the form should submitted as form data.
     * This will force Inertia Form to be submitted with forceFormData: true.
     * https://inertiajs.com/file-uploads#form-data-conversion
     *
     * @var bool
     */
    protected bool $forceFormData = false;

    /**
     * The value of the form.
     *
     * @var array
     */
    protected array $value = [];

    /**
     * Custom form context which can be accessed during validation.
     *
     * @var \Insight\Forms\Contracts\FormContext|null
     */
    protected ?FormContext $context = null;

    /**
     * Add a control to the form.
     *
     * @param \Insight\Forms\FormControl|\Insight\Forms\Field $control
     * @return \Insight\Forms\FormControl
     */
    public function control(FormControl|Field $control): FormControl
    {
        if ($control instanceof Field) {
            $control = FormControl::make($control);
        }

        $this->controls[] = $control;

        $control->required($control->guessRequired());

        return $control;
    }

    /**
     * Set the HTTP method used during form submission.
     *
     * @param string $method
     * @return $this
     */
    public function method(string $method): static
    {
        $this->method = strtolower($method);

        return $this;
    }

    /**
     * Retrieves the method used furing form submission.
     *
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * Set the location where the form should be submitted.
     *
     * @param string $action
     * @return $this
     */
    public function action(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Retrieve the action of the form.
     *
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * Forces the form to be submitted as FormData.
     * @see https://inertiajs.com/file-uploads#form-data-conversion
     *
     * @param bool $force
     * @return $this
     */
    public function forceFormData(bool $force = true): static
    {
        $this->forceFormData = $force;

        return $this;
    }

    /**
     * Set the custom form context.
     *
     * @param \Insight\Forms\Contracts\FormContext $context
     * @return $this
     */
    public function withContext(FormContext $context): static
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Determine if the given field value is present.
     *
     * @param string $field
     * @return bool
     */
    public function has(string $field): bool
    {
        return Arr::has($this->value, $field);
    }

    /**
     * Set value of given field.
     *
     * @param string $field
     * @param $value
     * @return $this
     */
    public function set(string $field, $value): static
    {
        Arr::set($this->value, $field, $value);

        return $this;
    }

    /**
     * Retrieve value of the field.
     *
     * @param string $field
     * @param $default
     * @return array|\ArrayAccess|mixed|null
     */
    public function get(string $field, $default = null): mixed
    {
        if ($this->has($field)) {
            return Arr::get($this->value, $field, $default);
        }

        return $default;
    }

    /**
     * Retrieve boolean value of the field.
     *
     * @param string $field
     * @param bool $default
     * @return bool
     */
    public function boolean(string $field, bool $default = false): bool
    {
        if ($this->has($field)) {
            return $this->get($field) === true;
        }

        return $default;
    }

    /**
     * Retrieve all form controls as collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function controls(): Collection
    {
        return collect($this->controls);
    }

    /**
     * Fills the form value from array.
     *
     * @param array $value
     * @return $this
     */
    public function fillFromArray(array $value): static
    {
        $this->controls()->each(fn (FormControl $control) => $this->set(
            field: $control->name(),
            value: $control->hydrateValueFromArray($control->name(), $value)
        ));

        return $this;
    }

    /**
     * Fills the form value from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return $this
     */
    public function fillFromRequest(Request $request): static
    {
        $this->controls()->each(fn (FormControl $control) => $this->set(
            field: $control->name(),
            value: $control->hydrateValueFromRequest($control->name(), $request)
        ));

        return $this;
    }

    /**
     * Fills the form from request or array.
     *
     * @param \Illuminate\Http\Request|array $value
     * @return $this
     */
    public function fill(Request|array $value): static
    {
        if ($value instanceof Request) {
            return $this->fillFromRequest($value);
        }

        return $this->fillFromArray($value);
    }

    /**
     * Returns the value of the form.
     *
     * @return array
     */
    public function value(): array
    {
        if (empty($this->value)) {
            return $this->getEmptyValue();
        }

        return $this->value;
    }

    /**
     * Retrieves the value of the Inertia form.
     *
     * @return array
     */
    public function getInertiaFormValue(): array
    {
        return $this->controls()
            ->mapWithKeys(fn (FormControl $control) => [
                $control->name() => $this->get($control->name(), fn () => $control->getEmptyValue())
            ])
            ->all();
    }

    /**
     * Retrieves empty value of the form.
     *
     * @return array
     */
    public function getEmptyValue(): array
    {
        return $this->controls()
            ->mapWithKeys(fn (FormControl $control) => [
                $control->name() => $control->getEmptyValue()
            ])
            ->all();
    }

    /**
     * Submits the form on given location using POST method.
     *
     * @param string $action
     * @return $this
     */
    public function postTo(string $action): static
    {
        return $this->method('post')->action($action);
    }

    /**
     * Creates new instance of the form.
     *
     * @return static
     */
    public static function make(): static
    {
        $form = new static();

        if (method_exists($form, "boot")) {
            $form->boot();
        }

        return $form;
    }

    /**
     * Capture form submission.
     * The validation is performed on the fields.
     *
     * @param \Illuminate\Http\Request|array $value
     * @return static
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function capture(Request|array $value): static
    {
        $form = static::make();

        $form->fill($value);

        $form->validate();

        return $form;
    }
}
