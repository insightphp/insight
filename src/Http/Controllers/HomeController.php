<?php


namespace Insight\Http\Controllers;


use Illuminate\Http\Request;
use Insight\Elements\View\Components\Link;
use Insight\Elements\View\Models\LinkActivation;
use Insight\Inertia\View\Page;
use Insight\View\Components\Header;
use Insight\View\Components\HeaderNavigation;
use Insight\View\Layouts\DrawerLayout;
use Insight\View\Layouts\InsightLayout;
use Insight\View\Models\Navigation;
use Insight\View\Models\NavigationItem;

class HomeController
{
    public function __invoke(Request $request)
    {
        return Page::render('insight:HomePage')->with([
            'location' => 'This is page on location: ' . $request->getUri(),
        ])->layout(InsightLayout::make(), DrawerLayout::make([
            'header' => Header::make([
                'leftNavigation' => HeaderNavigation::make()->withNavigation($this->createHeaderNavigation()),
                'rightNavigation' => HeaderNavigation::make()->withNavigation($this->createHeaderNavigation()),
            ])
        ]));
    }

    protected function createHeaderNavigation()
    {
        return Navigation::make()
            ->add(NavigationItem::for(Link::toRoute('Dashboard', 'dashboard', [], function (LinkActivation $activation) {
                $activation->onRoute('dashboard.overview')
                    ->onRoute('dashboard.notifications')
                    ->onRoute('dashboard.analytics')
                    ->onRoute('dashboard.saved-reports')
                    ->onRoute('dashboard.scheduled-reports')
                    ->onRoute('dashboard.user-reports');
            })))
            ->add(NavigationItem::for(Link::toRoute('Projects', 'projects', [], function (LinkActivation $activation) {
                $activation->onRoute('projects.pending')
                    ->onRoute('projects.published')
                    ->onRoute('projects.completed')
                    ->onRoute('projects.archived');
            })))
            ->add(NavigationItem::for(Link::toRoute('Tasks', 'tasks')))
            ->add(NavigationItem::for(Link::toRoute('Reporting', 'reporting')))
            ->add(NavigationItem::for(Link::toRoute('Users', 'users')));
    }

    protected function createDrawerNavigation()
    {
        return Navigation::make()
            ->add(NavigationItem::for(Link::toRoute('Dashboard', 'dashboard'))->setChildNavigation(
                Navigation::make()
                    ->add(NavigationItem::for(Link::toRoute('Overview', 'dashboard.overview')))
                    ->add(NavigationItem::for(Link::toRoute('Notifications', 'dashboard.notifications')))
                    ->add(NavigationItem::for(Link::toRoute('Analytics', 'dashboard.analytics')))
                    ->add(NavigationItem::for(Link::toRoute('Saved reports', 'dashboard.saved-reports')))
                    ->add(NavigationItem::for(Link::toRoute('Scheduled reports', 'dashboard.scheduled-reports')))
                    ->add(NavigationItem::for(Link::toRoute('User reports', 'dashboard.user-reports')))
            ))
            ->add(NavigationItem::for(Link::toRoute('Projects', 'projects'))->setChildNavigation(
                Navigation::make()
                    ->add(NavigationItem::for(Link::toRoute('Pending', 'projects.pending')))
                    ->add(NavigationItem::for(Link::toRoute('Published', 'projects.published')))
                    ->add(NavigationItem::for(Link::toRoute('Completed', 'projects.completed')))
                    ->add(NavigationItem::for(Link::toRoute('Archived', 'projects.archived')))
            ))
            ->add(NavigationItem::for(Link::toRoute('Tasks', 'tasks')))
            ->add(NavigationItem::for(Link::toRoute('Reporting', 'reporting')))
            ->add(NavigationItem::for(Link::toRoute('Users', 'users')));
    }
}
