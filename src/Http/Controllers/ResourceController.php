<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Elements\View\Components\Text;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\Header;
use Insight\Tables\View\Components\Row;
use Insight\Tables\View\Components\Table;
use Insight\View\Pages\ListResourcesPage;


class ResourceController
{
    public function index(Request $request)
    {


        return ListResourcesPage::make([
            'resources' => $this->createDemoTable(),
        ]);
    }

    protected function createDemoTable(): Table
    {
        $header = Header::make([
            'cells' => [
                Cell::make(['value' => Text::make(['value' => 'ID'])])->displayAsHeader(),
                Cell::make(['value' => Text::make(['value' => 'Name'])])->displayAsHeader(),
                Cell::make(['value' => Text::make(['value' => 'E-Mail'])])->displayAsHeader(),
                Cell::make(['value' => Text::make(['value' => 'Created At'])])->displayAsHeader(),
            ]
        ]);

        $users = \App\Models\User::query()->limit(10)->get();

        $table = Table::make([
            'header' => $header,
            'rows' => $users->map(function ($user) {
                return Row::make([
                    'cells' => [
                        Cell::make(['value' => Text::make(['value' => $user->id])]),
                        Cell::make(['value' => Text::make(['value' => $user->name])]),
                        Cell::make(['value' => Text::make(['value' => $user->email])->secondary()]),
                        Cell::make(['value' => Text::make(['value' => $user->created_at->format('d.m.Y H:i')])]),
                    ]
                ])->id($user->id);
            })->all(),
        ]);

        return $table;
    }
}
