<?php


namespace Insight\Forms;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Insight\Forms\Contracts\ConfiguresPendingValidation;
use Insight\Forms\Validation\PendingValidation;
use Insight\Forms\Validation\PreviousControls;

class FormControl
{
    /**
     * The name of the form control.
     *
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * The label of the form control.
     *
     * @var string|null
     */
    protected ?string $label = null;

    /**
     * Optional hint for the form control.
     *
     * @var string|null
     */
    protected ?string $hint = null;

    /**
     * Determine if the form control is required.
     * This does not guarantee validation of the form control for value presence.
     * It is used only for visuals, such as asterisk near label.
     *
     * @var bool|\Closure|null
     */
    protected bool|Closure|null $required = null;

    /**
     * The validation rules applied on the control.
     *
     * @var \Closure|array|string|null
     */
    protected Closure|array|string|null $rules = null;

    /**
     * The field that is going to be rendered for the control.
     *
     * @var \Insight\Forms\Field|\Closure|null
     */
    protected Field|null|Closure $field = null;

    /**
     * Retrieve the name of the control.
     *
     * @return string
     */
    public function name(): string
    {
        if ($this->name != null) {
            return $this->name;
        }

        return $this->guessName();
    }

    /**
     * Guess the name from the label.
     *
     * @return string
     */
    public function guessName(): string
    {
        return Str::snake(Str::studly($this->label));
    }

    /**
     * Set the control name.
     *
     * @param string $name
     * @return $this
     */
    public function withName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the control label.
     *
     * @param string $label
     * @return $this
     */
    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Retrieve the form label.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Set the hint of the control.
     *
     * @param string $hint
     * @return $this
     */
    public function hint(string $hint): static
    {
        $this->hint = $hint;

        return $this;
    }

    /**
     * Retrieves the hint for the control.
     *
     * @return string|null
     */
    public function getHint(): ?string
    {
        return $this->hint;
    }

    /**
     * Marks field visually as required.
     *
     * @param bool|\Closure $required
     * @return $this
     */
    public function required(bool|Closure $required = true): static
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Determines if the field is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        if (is_null($this->required)) {
            return false;
        }

        return value($this->required);
    }

    /**
     * Sets the validation rules for the control.
     *
     * @param \Closure|string|array $rules
     * @return $this
     */
    public function rules(Closure|string|array $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Retrieve applied rules on the control.
     *
     * @return string|array|null
     */
    public function getRules(): string|array|null
    {
        return value($this->rules);
    }

    /**
     * Hydrates value of the control from array.
     *
     * @param string $name
     * @param array $formValue
     * @return mixed
     */
    public function hydrateValueFromArray(string $name, array $formValue): mixed
    {
        return Arr::get($formValue, $name);
    }

    /**
     * Hydrates value of the control from request.
     *
     * @param string $name
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function hydrateValueFromRequest(string $name, Request $request): mixed
    {
        return $request->input($name);
    }

    /**
     * Retrieves empty value of the control.
     *
     * @return mixed
     */
    public function getEmptyValue(): mixed
    {
        return $this->field()->getEmptyValue();
    }

    /**
     * Set the field for the control.
     *
     * @param \Insight\Forms\Field|\Closure $field
     * @return $this
     */
    public function withField(Field|Closure $field): static
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Retrieves the underlying field of the control.
     *
     * @return \Insight\Forms\Field
     */
    public function field(): Field
    {
        if ($this->field instanceof Field) {
            return $this->field;
        }

        if ($this->field instanceof Closure) {
            return $this->field = call_user_func($this->field, $this);
        }

        throw new \RuntimeException("The field on the form control is not set.");
    }

    /**
     * Configures pending validation.
     *
     * @param \Insight\Forms\Validation\PendingValidation $pendingValidation
     * @return void
     */
    public function configureValidation(PendingValidation $pendingValidation): void
    {
        $field = $this->field();

        // Delegate configuration to field if the field is able to configure itself.
        if ($field instanceof ConfiguresPendingValidation) {
            $field->configurePendingValidation($pendingValidation, $this->name(), PreviousControls::empty());
            return;
        }

        // If the rule is provided, set in on pending validation.
        $rules = $this->getRules();

        if (is_array($rules) && Arr::isAssoc($rules)) {
            foreach ($rules as $key => $value) {
                $pendingValidation->rules()->set($key, $value);
            }
        } else if (! is_null($rules)) {
            $pendingValidation->rules()->set($this->name(), $rules);
        }
    }

    /**
     * Creates a new form control.
     *
     * @param \Closure|\Insight\Forms\Field $field
     * @param string|null $label
     * @param string|null $name
     * @return \Insight\Forms\FormControl
     */
    public static function make(Closure|Field $field, ?string $label = null, ?string $name = null): FormControl
    {
        $control = new FormControl();

        if ($label) {
            $control->label($label);
        }

        if ($name) {
            $control->withName($name);
        }

        return $control->withField($field);
    }

    /**
     * Guesses if the field should be required.
     *
     * @return bool
     */
    public function guessRequired(): bool
    {
        if ($this->isRequired()) {
            return true;
        }

        if (is_array($this->rules)) {
            return in_array('required', $this->rules);
        }

        return false;
    }
}
