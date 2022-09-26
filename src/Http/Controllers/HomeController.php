<?php


namespace Insight\Http\Controllers;


use Inertia\Inertia;

class HomeController
{
    public function __invoke()
    {
        // return Inertia::render('WelcomePage', [
        return Inertia::render('insight:HomePage', [

        ]);
    }
}
