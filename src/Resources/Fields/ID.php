<?php


namespace Insight\Resources\Fields;


class ID extends Text
{
    public function __construct(string $title = 'ID', \Closure|string|null $attribute = 'id')
    {
        parent::__construct($title, $attribute);

        $this->sortable($attribute);
    }
}
