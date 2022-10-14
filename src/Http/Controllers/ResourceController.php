<?php


namespace Insight\Http\Controllers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Insight\Elements\View\Components\Button;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Components\Pressable;
use Insight\Elements\View\Components\Stack;
use Insight\Elements\View\Components\Text;
use Insight\Tables\EloquentDataTable;
use Insight\Tables\View\Components\Cell;
use Insight\Tables\View\Components\Header;
use Insight\Tables\View\Components\Row;
use Insight\Tables\View\Components\Table;
use Insight\View\Components\Dialogs\DeleteResourceDialog;
use Insight\View\Components\Filter;
use Insight\View\Components\Filterables\SelectFilterable;
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
        $filter = Filter::make()
            ->filterable(
                SelectFilterable::make(['id' => 'account-type', 'title' => 'Account type'])
                    ->option('premium', 'Premium')
                    ->option('regular', 'Regular')
            )
            ->filterable(
                SelectFilterable::make(['id' => 'status', 'title' => 'Status'])
                    ->option('active', 'Active')
                    ->option('inactive', 'Inactive')
            )
            ->fillValueFromRequest($request)
        ;

        return ListResourcesPage::make([
            'resources' => $this->createDemoTable($request),
            'filter' => $filter,
        ])->dialog('delete-resource', function (Request $request) {
            $user = $request->input('user');

            if (is_numeric($user)) {
                $user = \App\Models\User::findOrFail($user);

                return DeleteResourceDialog::make([
                    'name' => $user->name
                ]);
            }

            return null;
        });
    }

    public function show(Request $request)
    {
        return ShowResourcePage::make();
    }

    public function edit(Request $request)
    {
        return EditResourcePage::make();
    }

    protected function createDemoTable(Request $request): Table
    {
        return (new EloquentDataTable(\App\Models\User::query(), $request, 'Users'))
            ->defaultSortAs('id')
            ->withHeader(
                Header::make([
                    'cells' => [
                        Cell::make(['value' => Text::make(['value' => 'ID'])])
                            ->displayAsHeader()
                            ->sortableAs('id'),
                        Cell::make(['value' => Text::make(['value' => 'Name'])])
                            ->displayAsHeader()
                            ->sortableAs('name'),
                        Cell::make(['value' => Text::make(['value' => 'E-Mail'])])
                            ->displayAsHeader(),
                        Cell::make(['value' => Text::make(['value' => 'Created At'])])
                            ->displayAsHeader()
                            ->sortableAs('created_at'),
                        Cell::make()->displayAsHeader()->right()
                    ]
                ])
            )
            ->createRowUsing(function ($user) {
                $actions = Stack::of([
                    Menu::withNavigation(
                        Navigation::make()
                            ->link(Link::toNowhere('Archive'))
                            ->link(Link::toNowhere('Impersionate'))
                            ->link(Link::toNowhere('Reset password'))
                    ),

                    Link::toDialog('Delete', 'delete-resource', [
                        'user' => $user->id,
                    ])->withContent(Pressable::for(Heroicon::solid('trash'))->danger()),

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
            })
            ->searchUsing(function (Builder $query, string $term) {
                $query->where(function (Builder $q) use ($term) {
                    $q->where('name', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%');
                });
            })
            ->withHeaderActions(
                Stack::of([
                    Menu::withNavigation(
                        Navigation::make()
                            ->link(Link::toNowhere('Active Users'))
                            ->link(Link::toNowhere('Disabled Users'))
                    )->withToggle(Button::withText('Insights', 'document-magnifying-glass')),
                    Link::toNowhere('Add User')->asButton('primary', 'plus'),
                ])->gap(3)
            )
            ->allowedSorts(['id', 'name', 'created_at'])
            ->toDataTable()
        ;
    }
}
