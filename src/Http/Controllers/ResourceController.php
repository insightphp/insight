<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Elements\View\Components\Text;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\Header;
use Insight\Tables\View\Components\Row;
use Insight\Tables\View\Components\Table;
use Insight\View\Pages\ListResourcesPage;

function cell()
{
    return Cell::make([
        'value' => Text::of('Cell'),
    ]);
}

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
                cell()->displayAsHeader(),
                cell()->displayAsHeader(),
                cell()->displayAsHeader(),
                cell()->displayAsHeader(),
            ]
        ]);

        $table = Table::make([
            'header' => $header,
            'rows' => [
                Row::make(['cells' => [cell(), cell(), cell(), cell()]]),
                Row::make(['cells' => [cell(), cell(), cell(), cell()]]),
                Row::make(['cells' => [cell(), cell(), cell(), cell()]]),
                Row::make(['cells' => [cell(), cell(), cell(), cell()]]),
                Row::make(['cells' => [cell(), cell(), cell(), cell()]]),
            ],
        ]);

        return $table;
    }
}
