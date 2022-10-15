<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Insight\Elements\View\Components\Link;
use Insight\View\Components\Dialogs\ConfirmableDialog;
use Insight\View\Components\Dialogs\Dialog;
use Insight\View\Components\Heroicon;

/**
 * @mixin \Insight\Resources\Resource
 */
trait Trashable
{
    /**
     * Creates dialog for resource deletion.
     *
     * @param \Illuminate\Database\Eloquent\Collection $resources
     * @param bool $force
     * @return \Insight\View\Components\Dialogs\Dialog|null
     */
    public function createDestroyDialog(Collection $resources, bool $force = false): ?Dialog
    {
        $title = ($force ? 'Permanently delete ' : 'Delete ') . ($resources->count() > 1 ? $resources->count() . ' ' . $this->getDisplayPluralName() : $this->getDisplayName());
        $message = ($resources->count() > 1 ? 'Are you sure you want to ' . ($force ? 'permanently delete ' : 'delete ') . $resources->count() . '  resources?' : 'Are you sure you want to ' . ($force ? 'permanently delete' : 'delete') . ' this resource?') . ' This action cannot be undone.';

        $actionTitle = $force ? 'Permanently delete' : 'Delete';

        if ($resources->count() == 1) {
            $resourceLinks = $this->createLinks($resources->first());
            $action = Link::toLocation($actionTitle, $resourceLinks->destroy($force ? ['force' => '1'] : []))->method('DELETE')->as('button');
        } else {
            $resourceLinks = $this->createLinks();
            $action = Link::toLocation($actionTitle, $resourceLinks->destroyMany())
                ->method('POST')->as('button')->withData(array_merge([
                    'resources' => $resources->map(fn (Model $model) => $model->getKey())->all()
                ], $force ? ['force' => true] : []));
        }

        return ConfirmableDialog::make([
            'title' => $title,
            'message' => $message,
            'icon' => Heroicon::outline('trash'),
        ])->danger()->confirmUsing($action->asButton('danger'));
    }

    /**
     * Creates dialog for resource restoration.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @return \Insight\View\Components\Dialogs\Dialog|null
     */
    public function createRestoreDialog(Model $resource): ?Dialog
    {
        $links = $this->createLinks($resource);

        return ConfirmableDialog::make([
            'title' => 'Restore ' . $this->getDisplayName(),
            'message' => 'Do you want to restore this resource?',
            'icon' => Heroicon::outline('arrow-uturn-left'),
        ])->success()->confirmUsing(
            Link::toLocation('Restore', $links->restore())->method('POST')->as('button')->asButton('success')
        );
    }

    /**
     * Determine if resource supports soft deletes.
     *
     * @return bool
     */
    public function supportsSoftDeletes(): bool
    {
        return in_array(SoftDeletes::class, class_uses($this->getModelClass()));
    }

}
