<?php


namespace Insight\Forms\Fields;


use Insight\Elements\View\Components\TextArea;
use Insight\Forms\Field;
use Insight\Inertia\ViewComponent;

/**
 * @deprecated
 */
class LongText extends Field
{
    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(TextArea::make());
    }
}
