<?php


namespace Insight\Forms;


use Illuminate\Contracts\Support\Arrayable;

class SelectOption implements Arrayable, \JsonSerializable
{
    public function __construct(
        public string $label,
        public mixed $value,
        public array $options = []
    ) {}

    /**
     * Retrieve the option label.
     *
     * @return string
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * Retrieve the option value.
     *
     * @return mixed
     */
    public function value(): mixed
    {
        return $this->value;
    }

    /**
     * Retrieve the option settings.
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Set the option label.
     *
     * @param string $label
     * @return void
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Set the option value.
     *
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Set the option settings.
     *
     * @param array $options
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function toArray()
    {
        return [
            'label' => $this->label(),
            'value' => $this->value(),
            'options' => $this->options(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * Creates a new option.
     *
     * @param string $label
     * @param mixed $value
     * @param array $options
     * @return static
     */
    public static function make(string $label, mixed $value, array $options = []): static
    {
        return new SelectOption($label, $value, $options);
    }
}
