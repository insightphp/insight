<?php


namespace Insight\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Insight\Facades\Insight;
use Insight\View\Pages\CreateResourcePage;
use Insight\View\Pages\EditResourcePage;

class ResourceController
{
    public function index(Request $request)
    {
        $resource = Insight::resolveResourceFromRequest($request);

        if (is_null($resource)) {
            abort(404, "The resource could not be found.");
        }

        if (! $resource->canViewAnyResources()) {
            abort(403, "You dont't have permissions to list resources.");
        }

        return $resource->toIndexPage($request);
    }

    public function show(Request $request)
    {
        $resource = Insight::resolveResourceFromRequest($request);

        if (is_null($resource)) {
            abort(404, "The resource could not be found.");
        }

        $model = $resource->newQuery()
            ->when($resource->supportsSoftDeletes(), fn ($q) => $q->withTrashed())
            ->findOrFail($request->route('id'));

        return $resource->toDetailPage($model);
    }

    public function create(Request $request)
    {
        return CreateResourcePage::make();
    }

    public function store(Request $request)
    {

    }

    public function edit(Request $request)
    {
        return EditResourcePage::make();
    }

    public function update(Request $request)
    {

    }

    public function restore(Request $request)
    {
        $resource = Insight::resolveResourceFromRequest($request);

        if (is_null($resource)) {
            abort(404, "The resource could not be found.");
        }

        if (! $resource->supportsSoftDeletes()) {
            abort(400, "The model is not restorable.");
        }

        $model = $resource->newQuery()->withTrashed()->findOrFail($request->route('id'));

        if ($model->trashed() && $resource->canRestoreResource($model)) {
            $model->restore();
        }

        return back();
    }

    public function destroy(Request $request)
    {
        $resource = Insight::resolveResourceFromRequest($request);

        if (is_null($resource)) {
            abort(404, "The resource could not be found.");
        }

        $force = $request->boolean('force');

        $model = $resource->newQuery()
            ->when($resource->supportsSoftDeletes() && $force, fn ($q) => $q->withTrashed())
            ->findOrFail($request->route('id'));

        if ($force) {
            if (! $resource->canForceDeleteResource($model)) {
                abort(403, "You are not authorized to permanently delete this resource.");
            }

            if (! $model->forceDelete()) {
                // TODO: SHow that model coult not be deleted.
            }
        } else {
            if (! $resource->canDeleteResource($model)) {
                abort(403, "You are not authorized to delete this resource.");
            }

            if (! $model->delete()) {
                // TODO: Show that model could not be deleted.
            }
        }

        // TODO: Flash success

        return back();
    }

    public function destroyMany(Request $request)
    {
        $resource = Insight::resolveResourceFromRequest($request);

        if (is_null($resource)) {
            abort(404, "The resource could not be found.");
        }

        $ids = collect($request->input('resources'))
            ->filter(fn ($id) => is_string($id) || is_numeric($id));

        if ($ids->isEmpty()) {
            abort(400, "No resources to delete.");
        }

        $model = $resource->newModel();

        $models = $resource->newQuery()
            ->whereIn($model->getKeyName(), $ids->all())
            ->get()
            ->filter(fn (Model $model) => $resource->canDeleteResource($model));

        if ($models->isEmpty()) {
            abort(400, "No resources to delete.");
        }

        $models->each(function (Model $model) {
            $model->delete();
        });

        // TODO: Flash success

        return back();
    }
}
