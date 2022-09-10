<?php


namespace Insight\Forms\Fields;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Insight\Forms\Field;
use Insight\Forms\SelectOption;
use Insight\Forms\ViewComponents\Select as SelectView;
use Insight\Inertia\ViewComponent;

class Select extends Field
{
    /**
     * Add option to the select.
     *
     * @param \Insight\Forms\SelectOption $option
     * @return $this
     */
    public function option(SelectOption $option): static
    {
        return $this->apply(fn (SelectView $select) => $select->option($option));
    }

    /**
     * Clears all select options.
     *
     * @return $this
     */
    public function clearOptions(): static
    {
        return $this->apply(fn (SelectView $select) => $select->clearOptions());
    }

    /**
     * Add options to select from array or collection.
     *
     * @param array|\Illuminate\Support\Collection $options
     * @param bool $merge
     * @return $this
     */
    public function optionsFromArray(array|Collection $options, bool $merge = true): static
    {
        if ($options instanceof Collection) {
            $options = $options->all();
        }

        return $this->apply(function (SelectView $select) use ($options, $merge) {
            if (! $merge) {
                $select->clearOptions();
            }

            if (Arr::isAssoc($options)) {
                foreach ($options as $key => $value) {
                    $select->option(SelectOption::make($value, $key));
                }
            } else {
                foreach ($options as $option) {
                    $select->option($option);
                }
            }
        });
    }

    public function resolveViewComponent(): ViewComponent
    {
        return $this->withConfigurationsOn(SelectView::make());
    }
}
