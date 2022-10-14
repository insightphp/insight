<?php


namespace Insight\View\Components\Dialogs;


use Illuminate\Support\Str;
use Insight\Inertia\Support\Computed;
use Insight\Inertia\View\Component;

abstract class Dialog extends Component
{
    #[Computed]
    public function id(): string
    {
        return Str::random();
    }
}
