<?php


namespace Insight\Resources\Dialogs;


use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Link;
use Insight\Resources\Resource;
use Insight\View\Components\Dialogs\ConfirmableDialog;
use Insight\View\Components\Dialogs\Dialog;
use Insight\View\Components\Heroicon;

class RestoreResourceDialog extends DialogFactory
{
    const NAME = 'restore-resource';

    public function __construct(
        protected Resource $resource
    ) {}

    public function build(): ?Dialog
    {
        if (! $this->resource->supportsSoftDeletes()) {
            return null;
        }

        $model = $this->getModelToRestore();

        if (! $this->resource->canRestoreResource($model)) {
            return null;
        }

        if (! $model->trashed()) {
            return null;
        }

        $links = $this->resource->createLinks($model);

        return ConfirmableDialog::make([
            'title' => 'Restore ' . $this->resource->getDisplayName(),
            'message' => "Do you want to restore this {$this->resource->getDisplayName()}?",
            'icon' => Heroicon::outline('arrow-uturn-left'),
        ])->success()->confirmUsing(
            Link::toLocation('Restore', $links->restore())
                ->preserveScroll()->method('POST')->as('button')->asButton('success')
        );
    }

    protected function getModelToRestore(): Model
    {
        $id = $this->input('resource');

        if (is_string($id) || is_numeric($id)) {
            return $this->resource->newQuery()->withTrashed()->findOrFail($id);
        }

        return abort(404, "The resource could not be found.");
    }
}
