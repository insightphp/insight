<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Elements\View\Components\Button;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Pressable;
use Insight\Elements\View\Components\Stack;
use Insight\Elements\View\Components\Text;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\DataTable;
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

        /** @var \Illuminate\Pagination\LengthAwarePaginator $users */
        $users = \App\Models\User::query()
            ->paginate(25)
            ->onEachSide(1);

        $table = DataTable::make([
            'headerActions' => Stack::of([
                Menu::withNavigation(
                    Navigation::make()
                        ->link(Link::toNowhere('Active Users'))
                        ->link(Link::toNowhere('Disabled Users'))
                )->withToggle(Button::withText('Insights', 'document-magnifying-glass')),
                Link::toNowhere('Add User')
                    ->asButton('primary', 'plus'),
            ])->gap(3),
            'title' => 'Users',
            'totalItems' => $users->total(),
            'header' => $header,
            'rows' => collect($users->items())->map(function ($user) {
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
                        Cell::make(['value' => Text::make(['value' => $user->name])->primary()]),
                        Cell::make(['value' => Text::make(['value' => $user->email])->secondary()]),
                        Cell::make(['value' => Text::make(['value' => $user->created_at->format('d.m.Y H:i')])]),
                        Cell::make(['value' => $actions])->right()
                    ]
                ])->id($user->id);
            })->all(),
        ])->addPaginationLinks($users->linkCollection())->withBulkSelection();

        return $table;
    }
}
