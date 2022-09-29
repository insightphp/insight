<?php


namespace Insight\Http\Controllers;


use Insight\Inertia\View\Page;
use Insight\View\Components\Header;
use Insight\View\Components\HeaderNavigation;
use Insight\View\Layouts\DrawerLayout;
use Insight\View\Layouts\InsightLayout;

class HomeController
{
    public function __invoke()
    {
        return Page::render('insight:HomePage', [
            //
        ])->layout(InsightLayout::make(), DrawerLayout::make([
            'header' => Header::make([
                // 'leftNavigation' => HeaderNavigation::make(),
                // 'rightNavigation' => HeaderNavigation::make(),
            ])
        ]));
    }
}
