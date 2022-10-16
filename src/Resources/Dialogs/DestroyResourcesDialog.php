<?php


namespace Insight\Resources\Dialogs;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Insight\Elements\View\Components\Link;
use Insight\Resources\Resource;
use Insight\View\Components\Dialogs\ConfirmableDialog;
use Insight\View\Components\Dialogs\Dialog;
use Insight\View\Components\Heroicon;

class DestroyResourcesDialog extends DialogFactory
{
    const NAME = 'destroy-resources';

    public function __construct(
        protected Resource $resource
    ) {}

    public function build(): ?Dialog
    {
        $force = $this->isForceDelete();
        $ids = $this->resourceIds();

        if ($ids->isEmpty()) {
            return null;
        }

        $model = $this->resource->newModel();

        $resources = $this->resource->newQuery()
            ->when($this->resource->supportsSoftDeletes() && $force, fn ($query) => $query->withTrashed())
            ->whereIn($model->getRouteKeyName(), $ids)
            ->get()
            ->filter(fn (Model $model) => $this->resource->canDeleteResource($model));

        if ($resources->isEmpty()) {
            return null;
        }

        return ConfirmableDialog::make([
            'title' => $this->title($force, $resources->count()),
            'message' => $this->message($force, $resources->count()),
            'icon' => Heroicon::outline('trash'),
        ])->confirmUsing($this->confirmAction($force, $resources))->danger();
    }

    /**
     * Create action for confirming the dialog.
     *
     * @param bool $force
     * @param \Illuminate\Support\Collection $models
     * @return \Insight\Elements\View\Components\Link
     */
    protected function confirmAction(bool $force, Collection $models): Link
    {
        $actionTitle = $force ? 'Permanently delete' : 'Delete';

        if ($models->count() == 1) {
            $resourceLinks = $this->resource->createLinks($models->first());
            $action = Link::toLocation($actionTitle, $resourceLinks->destroy($force ? ['force' => '1'] : []))->method('DELETE')->as('button');
        } else {
            $resourceLinks = $this->resource->createLinks();
            $action = Link::toLocation($actionTitle, $resourceLinks->destroyMany())
                ->method('POST')->as('button')->withData(array_merge([
                    'resources' => $models->map(fn (Model $model) => $model->getKey())->all()
                ], $force ? ['force' => true] : []));
        }

        return $action->asButton('danger');
    }

    /**
     * Create title of the dialog.
     *
     * @param bool $force
     * @param int $count
     * @return string
     */
    protected function title(bool $force, int $count): string
    {
        if ($count > 1) {
            return ($force ? 'Permanently delete ' : 'Delete ') . $count . ' ' . $this->resource->getDisplayPluralName();
        }

        return ($force ? 'Permanently delete ' : 'Delete ') . $this->resource->getDisplayName();
    }

    /**
     * Create message of the dialog.
     *
     * @param bool $force
     * @param int $count
     * @return string
     */
    protected function message(bool $force, int $count): string
    {
        $message = $count > 1
            ? "Are you sure you want to". ($force ? ' permanently' : '') ." delete {$count} {$this->resource->getDisplayPluralName()}?"
            : "Are you sure you want to". ($force ? ' permanently' : '') ." delete this {$this->resource->getDisplayName()}?";

        return $force ? $message . ' This action results in permanent data loss.' : $message;
    }

    /**
     * Determine if we should force delete resources.
     *
     * @return bool
     */
    protected function isForceDelete(): bool
    {
        return $this->boolean('force');
    }

    /**
     * List of resource IDs to delete.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function resourceIds(): Collection
    {
        return collect($this->input('resources', []))
            ->filter(fn ($it) => is_string($it) || is_numeric($it));
    }
}
