<?php


namespace Insight\View\Components\Filterables;


class SelectFilterable extends Filterable
{
    /**
     * The options of the filterable.
     *
     * @var array
     */
    public array $options = [];

    /**
     * Add option to the select.
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
}
