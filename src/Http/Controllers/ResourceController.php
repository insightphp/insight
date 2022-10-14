<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Facades\Insight;
use Insight\View\Pages\EditResourcePage;
use Insight\View\Pages\ShowResourcePage;

class ResourceController
{
    public function index(Request $request)
    {
        $resource = Insight::resolveResourceFromRequest($request);

        if (is_null($resource)) {
            abort(404, "The resource could not be found.");
        }

        return $resource->toIndexPage($request);
        // $filter = Filter::make()
        //     ->filterable(
        //         SelectFilterable::make(['id' => 'account-type', 'title' => 'Account type'])
        //             ->option('premium', 'Premium')
        //             ->option('regular', 'Regular')
        //     )
        //     ->filterable(
        //         SelectFilterable::make(['id' => 'status', 'title' => 'Status'])
        //             ->option('active', 'Active')
        //             ->option('inactive', 'Inactive')
        //     )
        //     ->fillValueFromRequest($request)

        //     return (new EloquentDataTable(\App\Models\User::query(), $request, 'Users'))
        //         ->withHeaderActions(
        //             Stack::of([
        //                 Menu::withNavigation(
        //                     Navigation::make()
        //                         ->link(Link::toNowhere('Active Users'))
        //                         ->link(Link::toNowhere('Disabled Users'))
        //                 )->withToggle(Button::withText('Insights', 'document-magnifying-glass')),
        //                 Link::toNowhere('Add User')->asButton('primary', 'plus'),
        //             ])->gap(3)
        //         )
    }

    public function show(Request $request)
    {
        return ShowResourcePage::make();
    }

    public function edit(Request $request)
    {
        return EditResourcePage::make();
    }
}
