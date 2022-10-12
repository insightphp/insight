<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Pressable;
use Insight\Elements\View\Components\Stack;
use Insight\Elements\View\Components\Text;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\Header;
use Insight\Tables\View\Components\Row;
use Insight\Tables\View\Components\Table;
use Insight\View\Components\Heroicon;
use Insight\View\Components\Menu;
use Insight\View\Models\Navigation;
use Insight\View\Pages\EditResourcePage;
use Insight\View\Pages\ListResourcesPage;
use Insight\View\Pages\ShowResourcePage;


class ResourceController
{
    public function index(Request $request)
    {


        return ListResourcesPage::make([
            'resources' => $this->createDemoTable(),
        ]);
    }

    public function show(Request $request)
    {
        return ShowResourcePage::make();
    }

    public function edit(Request $request)
    {
        return EditResourcePage::make();
    }

    protected function createDemoTable(): Table
    {
        $header = Header::make([
            'cells' => [
                Cell::make(['value' => Text::make(['value' => 'ID'])])->displayAsHeader(),
                Cell::make(['value' => Text::make(['value' => 'Name'])])->displayAsHeader(),
                Cell::make(['value' => Text::make(['value' => 'E-Mail'])])->displayAsHeader(),
                Cell::make(['value' => Text::make(['value' => 'Created At'])])->displayAsHeader(),
                Cell::make()->displayAsHeader()->right()
            ]
        ]);

        $users = \App\Models\User::query()->limit(10)->get();

        $table = Table::make([
            'header' => $header,
            'rows' => $users->map(function ($user) {
                $actions = Stack::of([
                    Menu::withNavigation(
                        Navigation::make()
                            ->link(Link::toNowhere('Archive'))
                            ->link(Link::toNowhere('Impersionate'))
                            ->link(Link::toNowhere('Reset password'))
                    ),

                    Pressable::for(Heroicon::solid('trash'))->danger(),

                    Link::toRoute('Edit', 'insight.resources.edit', [
                        'resource' => 'users',
                        'id' => $user->id,
                    ])->withPressableContent(Heroicon::solid('pencil')),

                    Link::toRoute('Show', 'insight.resources.show', [
                        'resource' => 'users',
                        'id' => $user->id,
                    ])->withContent(Pressable::for(Heroicon::solid('eye'))->primary()),
                ]);

                return Row::make([
                    'cells' => [
                        Cell::make(['value' => Text::make(['value' => $user->id])]),
                        Cell::make(['value' => Text::make(['value' => $user->name])]),
                        Cell::make(['value' => Text::make(['value' => $user->email])->secondary()]),
                        Cell::make(['value' => Text::make(['value' => $user->created_at->format('d.m.Y H:i')])]),
                        Cell::make(['value' => $actions])->right()
                    ]
                ])->id($user->id);
            })->all(),
        ]);

        return $table;
    }
}
