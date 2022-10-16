<?php


namespace Insight\Forms\Validation;


class PreviousControls
{
    /**
     * Form control names of previous fields.
     *
     * @var array
     */
    protected array $names = [];

    /**
     * Nullable/optional states of previous fields.
     *
     * @var array
     */
    protected array $nullables = [];

    /**
     * States if all previous fields are filled.
     *
     * @var array
     */
    protected array $filled = [];

    /**
     * Retrieve array of previous control names plus additional control name.
     *
     * @param string $formControlName
     * @return array
     */
    public function andWithCurrent(string $formControlName): array
    {
        return array_merge($this->names, [$formControlName]);
    }

    /**
     * Determine if previously was some control nullable.
     *
     * @return bool
     */
    public function wasSomethingNullable(): bool
    {
        return in_array(true, $this->nullables);
    }

    /**
     * Check if there wasn't any previous controls.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->names);
    }

    /**
     * Create full control names path.
     *
     * @param string|null $append
     * @param string $glue
     * @return string
     */
    public function toNamesPath(string $append = null, string $glue = '.'): string
    {
        if ($append != null) {
            return $this->clone()->appendField($append, false, false)->toNamesPath(null, $glue);
        }

        return implode($glue, $this->names);
    }

    protected function ensureAttributesInSync(): void
    {
        if ((count($this->names) == count($this->nullables)) && (count($this->nullables) == count($this->filled))) {
            return;
        }

        throw new \RuntimeException("Looks like names/nullables/filled are not in sync.");
    }

    /**
     * Check if some previous control was optional and was not filled.
     *
     * @return bool
     */
    public function wasPreviousOptionalValueNotFilled(): bool
    {
        $this->ensureAttributesInSync();

        if (count($this->names) == 0) {
            return false;
        }

        for ($i = 0; $i < count($this->names); $i++) {
            if ($this->nullables[$i] && !$this->filled[$i]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create next previous control.
     *
     * @param string $currentFieldName
     * @param bool $isCurrentNullable
     * @param bool $isCurrentFilled
     * @return \Insight\Forms\Validation\PreviousControls
     */
    public function next(string $currentFieldName, bool $isCurrentNullable, bool $isCurrentFilled): PreviousControls
    {
        return $this->clone()->appendField($currentFieldName, $isCurrentNullable, $isCurrentFilled);
    }

    protected function appendField(string $name, bool $nullable, bool $filled): PreviousControls
    {
        $this->names[] = $name;
        $this->nullables[] = $nullable;
        $this->filled[] = $filled;

        return $this;
    }

    protected function clone(): PreviousControls
    {
        $control = new PreviousControls();
        $control->names = $this->names;
        $control->nullables = $this->nullables;
        $control->filled = $this->filled;
        return $control;
    }

    /**
     * Create new instance of previous controls.
     *
     * @return \Insight\Forms\Validation\PreviousControls
     */
    public static function empty(): PreviousControls
    {
        return new PreviousControls();
    }
}
