<?php


namespace Insight\Forms\Fields;


use Insight\Elements\View\Components\TextInput;
use Insight\Forms\Field;

/**
 * @deprecated
 */
class Text extends Field
{
    public function __construct()
    {
        $this->component = TextInput::make();
    }
}
