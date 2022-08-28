<?php


namespace Insight\Forms\Validation;


use Illuminate\Support\Arr;

class Rules
{
    protected array $rules = [];

    /**
     * Set the validation rule for the field.
     *
     * @param string $key
     * @param string|array|\Insight\Forms\Validation\Closure $rule
     * @return $this
     */
    public function set(string $key, string|array|Closure $rule): static
    {
        $this->rules[$key] = $rule;

        return $this;
    }

    /**
     * Retrieve rules for given field.
     *
     * @param string $key
     * @return string|array|\Closure|null
     */
    public function get(string $key): string|array|Closure|null
    {
        return Arr::get($this->rules, $key);
    }

    /**
     * Determine if the validation rule for the field is present.
     *
     * @param string|array $key
     * @return bool
     */
    public function has(string|array $key): bool
    {
        return Arr::has($this->rules, $key);
    }

    /**
     * Remove validation rules for given fields.
     *
     * @param string|array $key
     * @return $this
     */
    public function forget(string|array $key): static
    {
        Arr::forget($this->rules, $key);

        return $this;
    }

    /**
     * Merge rules with other validation rules.
     *
     * @param Rules $rules
     * @param string $prefix
     * @return $this
     */
    public function merge(Rules $rules, string $prefix = ''): static
    {
        foreach ($rules->all() as $field => $rule) {
            $this->set($prefix . $field, $rule);
        }

        return $this;
    }

    /**
     * Merge inner validation rules.
     *
     * @param Rules $rules
     * @param string $key
     * @return $this
     */
    public function mergeInner(Rules $rules, string $key): static
    {
        return $this->merge($rules, $key . '.');
    }

    /**
     * Merge inner array validation rules.
     *
     * @param Rules $rules
     * @param string $key
     * @return $this
     */
    public function mergeInnerArray(Rules $rules, string $key): static
    {
        return $this->merge($rules, $key . '.*.');
    }

    /**
     * Retrieve all validation rules as array.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->rules;
    }

    /**
     * Retrieve rules for validator.
     *
     * @return array
     */
    public function toRules(): array
    {
        return $this->all();
    }

    /**
     * Create validation rules from array.
     *
     * @param array $rules
     * @return static
     */
    public static function of(array $rules): static
    {
        $validationRules = new Rules();

        foreach ($rules as $name => $rule) {
            $validationRules->set($name, $rule);
        }

        return $validationRules;
    }
}
