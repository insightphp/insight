<?php


namespace Insight\Resources\Concerns;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Insight\Elements\View\Components\Link;
use Insight\View\Components\Dialogs\ConfirmableDialog;
use Insight\View\Components\Dialogs\Dialog;
use Insight\View\Components\Heroicon;

/**
 * @mixin \Insight\Resources\Resource
 */
trait CanBeDestroyedFromDialog
{
    /**
     * Creates dialog for resource deletion.
     *
     * @param \Illuminate\Database\Eloquent\Collection $resources
     * @return \Insight\View\Components\Dialogs\Dialog|null
     */
    public function createDestroyDialog(Collection $resources): ?Dialog
    {
        $title = 'Delete ' . ($resources->count() > 1 ? $resources->count() . ' ' . $this->getDisplayPluralName() : $this->getDisplayName());
        $message = ($resources->count() > 1 ? 'Are you sure you want to delete ' . $resources->count() . '  resources?' : 'Are you sure you want to delete this resource?') . ' This action cannot be undone.';


        if ($resources->count() == 1) {
            $resourceLinks = $this->createLinks($resources->first());
            $action = Link::toLocation('Delete', $resourceLinks->destroy())->method('DELETE')->as('button');
        } else {
            $resourceLinks = $this->createLinks();
            $action = Link::toLocation('Delete', $resourceLinks->destroyMany())
                ->method('POST')->as('button')->withData([
                    'resources' => $resources->map(fn (Model $model) => $model->getKey())->all()
                ]);
        }

        return ConfirmableDialog::make([
            'title' => $title,
            'message' => $message,
            'icon' => Heroicon::outline('trash'),
        ])->danger()->confirmUsing($action->asButton('danger'));
    }
}
