<?php


namespace Insight\Resources\Concerns;


use Insight\Resources\Dialogs\DestroyResourcesDialog;
use Insight\Resources\Dialogs\RestoreResourceDialog;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CreatesDialogs
{
    /**
     * Retrieve list of dialog factories for the index page.
     *
     * @return \Closure[]
     */
    public function getDialogsForIndex(): array
    {
        return [
            DestroyResourcesDialog::NAME => function (array $input) {
                return DestroyResourcesDialog::create($input, $this);
            },
            RestoreResourceDialog::NAME => function (array $input) {
                return RestoreResourceDialog::create($input, $this);
            },
        ];
    }

    /**
     * Retrieve list of dialog factories for the detail page.
     *
     * @return \Closure[]
     */
    public function getDialogsForDetail(): array
    {
        return [
            DestroyResourcesDialog::NAME => function (array $input) {
                return DestroyResourcesDialog::create($input, $this);
            },
            RestoreResourceDialog::NAME => function (array $input) {
                return RestoreResourceDialog::create($input, $this);
            },
        ];
    }
}
