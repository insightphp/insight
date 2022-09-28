<?php


namespace Insight\Elements\View;


use Illuminate\Contracts\Support\Arrayable;

class Option implements Arrayable, \JsonSerializable
{
    public function __construct(
        public string $label,
        public mixed $value,
        public array $meta = []
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
     * Retrieve the option meta.
     *
     * @return array
     */
    public function meta(): array
    {
        return $this->meta;
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
     * Set the option meta.
     *
     * @param array $meta
     * @return void
     */
    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }

    public function toArray()
    {
        return [
            'label' => $this->label(),
            'value' => $this->value(),
            'meta' => $this->meta(),
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
     * @param array $meta
     * @return static
     */
    public static function make(string $label, mixed $value, array $meta = []): static
    {
        return new Option($label, $value, $meta);
    }
}
