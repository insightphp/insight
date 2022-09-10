<?php


namespace Insight\Forms\Fields;


use Insight\Forms\Field;
use Insight\Forms\ViewComponents\TextArea;
use Insight\Inertia\ViewComponent;

class LongText extends Field
{
    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(TextArea::make());
    }
}
