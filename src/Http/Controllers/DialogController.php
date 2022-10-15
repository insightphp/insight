<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DialogController
{
    public function __invoke(Request $request)
    {
        $dialogName = $request->route('dialog');

        $params = $request->except('dialog');

        Session::flash('showInsightDialog', [
            'dialog' => $dialogName,
            'params' => $params,
        ]);

        return redirect()->back();
    }
}
