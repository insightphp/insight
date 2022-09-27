<?php


namespace Insight\Http\Controllers;


use Insight\Inertia\View\Page;
use Insight\View\Components\Layouts\DashboardLayout;

class HomeController
{
    public function __invoke()
    {
        return Page::render('insight:HomePage', [
            //
        ])->layout(DashboardLayout::make());
    }
}
