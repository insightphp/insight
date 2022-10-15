<?php


namespace Insight\View\Components\Filterables;


use Insight\Filter\Filterable;

class BooleanFilterable extends Filterable
{
    /**
     * Available boolean options.
     *
     * @var array
     */
    public array $options = [];

    /**
     * Add boolean option.
     *
     * @param string $id
     * @param string $title
     * @return $this
     */
    public function option(string $id, string $title): static
    {
        $this->options[] = ['id' => $id, 'title' => $title];

        return $this;
    }

    public function getEmptyValue(): mixed
    {
        return [];
    }

    public function isValueConsideredEmpty(mixed $value): bool
    {
        return is_array($value) && empty($value);
    }
}
