<?php


namespace Insight\Forms\Fields;


use Insight\Elements\TextInput;
use Insight\Forms\Field;
use Insight\Inertia\ViewComponent;

/**
 * @mixin \Insight\Elements\TextInput
 */
class Text extends Field
{
    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(TextInput::make());
    }
}
