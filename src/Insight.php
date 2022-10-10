<?php


namespace Insight;


use Insight\Inertia\View\Component;
use Insight\Inertia\View\LayoutStack;
use Insight\View\Pages\InsightPage;

class Insight
{
    /**
     * Global layouts applied on the Insight pages.
     *
     * @var \Insight\Inertia\View\LayoutStack
     */
    protected LayoutStack $layouts;

    public function __construct()
    {
        $this->layouts = new LayoutStack();
    }

    /**
     * Add global layout for Insight pages.
     *
     * @param \Insight\Inertia\View\Component $layout
     * @return $this
     */
    public function addGlobalLayout(Component $layout): static
    {
        $this->layouts->add($layout);

        return $this;
    }

    /**
     * Retrieves global layouts for Insight pages.
     *
     * @return \Insight\Inertia\View\LayoutStack
     */
    public function getLayouts(): LayoutStack
    {
        return $this->layouts;
    }

    /**
     * Renders given page as Insight page.
     *
     * @param string $page
     * @param array $data
     * @return \Insight\View\Pages\InsightPage
     */
    public function render(string $page, array $data = []): InsightPage
    {
        return InsightPage::render($page)->with($data);
    }
}
