<?php


namespace Insight\Forms\Fields;


use Insight\Forms\Field;
use Insight\Inertia\ViewComponent;

class Color extends Field
{
    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(\Insight\Elements\Color::make());
    }
}
