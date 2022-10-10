<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Facades\Insight;

class HomeController
{
    public function __invoke(Request $request)
    {
        return Insight::render('insight:HomePage', [
            'location' => 'This is page on location: ' . $request->getUri(),
        ]);
    }
}
