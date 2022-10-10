<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\View\Pages\ListResourcesPage;

class ResourceController
{
    public function index(Request $request)
    {
        return ListResourcesPage::make();
    }
}
