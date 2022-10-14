<?php


namespace Insight\Resources;


class Sorting
{
    public function __construct(
        protected string $column,
        protected string $direction
    ) {}

    /**
     * Retrieve the column for the sorting.
     *
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * Retrieve the direction of the sorting.
     *
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * Creates new asc sorting for the given column.
     *
     * @param string $column
     * @return static
     */
    public static function asc(string $column): static
    {
        return new Sorting($column, 'asc');
    }

    /**
     * Creates new desc sorting for the given column.
     *
     * @param string $column
     * @return static
     */
    public static function desc(string $column): static
    {
        return new Sorting($column, 'desc');
    }
}
