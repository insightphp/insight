<?php


namespace Insight\Resources\Fields;


use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Text as TextComponent;
use Insight\Inertia\View\Component;
use Insight\Resources\Field;
use Insight\Resources\Resource;

class Text extends Field
{
    protected function resolveTextField(Resource $resource, Model $model): TextComponent
    {
        $value = $this->getValue($resource, $model);

        return TextComponent::of($value);
    }

    protected function resolveTableField(Resource $resource, Model $model): Component
    {
        return $this->resolveTextField($resource, $model);
    }

    protected function resolvePanelField(Resource $resource, Model $model): Component
    {
        return $this->resolveTextField($resource, $model)
            ->small()
            ->span()
            ->primary();
    }
}
