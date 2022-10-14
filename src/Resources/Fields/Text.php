<?php


namespace Insight\Resources\Fields;


use Illuminate\Database\Eloquent\Model;
use Insight\Inertia\View\Component;
use Insight\Resources\Field;
use Insight\Resources\Resource;

class Text extends Field
{
    protected function resolveTableField(Resource $resource, Model $model): Component
    {
        $value = $this->getValue($resource, $model);

        return \Insight\Elements\View\Components\Text::of($value);
    }
}
