<?php


namespace Insight\Providers;


use Illuminate\Support\ServiceProvider;
use Insight\Insight;
use Insight\View\Components\Header;
use Insight\View\Components\HeaderNavigation;
use Insight\View\Layouts\DrawerLayout;
use Insight\View\Layouts\InsightLayout;
use Insight\View\Models\Navigation;
use Insight\View\Models\User;

class InsightAppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('insight', fn () => new Insight());
        $this->app->alias('insight', Insight::class);
    }

    public function boot()
    {
        $this->app->booted(function () {
            $insight = $this->app->make('insight');

            $this->configureGlobalLayouts($insight);
        });
    }

    /**
     * Configure global layouts for Insight pages.
     *
     * @param \Insight\Insight $insight
     * @return void
     */
    public function configureGlobalLayouts(Insight $insight): void
    {
        $root = InsightLayout::make();
        $this->configureInsightLayout($root);

        $insight->addGlobalLayout($root);

        $leftHeaderSections = Navigation::make();
        $this->configureLeftSectionsNavigation($leftHeaderSections);
        $rightHeaderSections = Navigation::make();
        $this->configureRightSectionsNavigation($rightHeaderSections);
        $userNavigation = Navigation::make();
        $this->configureUserNavigation($userNavigation);

        $header = Header::make([
            'leftNavigation' => HeaderNavigation::make()->withNavigation($leftHeaderSections),
            'rightNavigation' => HeaderNavigation::make()->withNavigation($rightHeaderSections),
            'userNavigation' => $userNavigation,
            'user' => $this->resolveInsightUser(),
        ]);

        $drawerNavigation = Navigation::make();
        $this->configureDrawerNavigation($drawerNavigation);

        $drawer = DrawerLayout::make([
            'header' => $header,
        ])->withNavigation($drawerNavigation);
        $this->configureDrawerLayout($drawer);
        $insight->addGlobalLayout($drawer);
    }

    /**
     * Configure root Insight layout.
     *
     * @param \Insight\View\Layouts\InsightLayout $layout
     * @return void
     */
    public function configureInsightLayout(InsightLayout $layout): void
    {
        //
    }

    /**
     * Configure drawer layout.
     *
     * @param \Insight\View\Layouts\DrawerLayout $layout
     * @return void
     */
    public function configureDrawerLayout(DrawerLayout $layout): void
    {
        //
    }

    /**
     * Configure sections navigation in the header on the left side.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return void
     */
    public function configureLeftSectionsNavigation(Navigation $navigation): void
    {
        //
    }

    /**
     * Configure sections navigation in the header on right side.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return void
     */
    public function configureRightSectionsNavigation(Navigation $navigation): void
    {
        //
    }

    /**
     * Configure navigation in the navigation drawer.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return void
     */
    public function configureDrawerNavigation(Navigation $navigation): void
    {
        //
    }

    /**
     * Retrieve the Insight user.
     *
     * @return \Insight\View\Models\User|null
     */
    public function resolveInsightUser(): ?User
    {
        return null;
    }

    /**
     * Configure user navigation.
     *
     * @param \Insight\View\Models\Navigation $navigation
     * @return void
     */
    public function configureUserNavigation(Navigation $navigation): void
    {
        //
    }

}
