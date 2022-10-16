<?php


namespace Insight\Forms\Fields;


use Insight\Forms\Field;
use Insight\Inertia\ViewComponent;

/**
 * @deprecated
 */
class Color extends Field
{
    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(\Insight\Elements\View\Components\Color::make());
    }
}
