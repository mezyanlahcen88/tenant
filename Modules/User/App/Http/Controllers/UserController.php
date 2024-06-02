<?php

namespace Modules\User\app\Http\Controllers;

use App\Enums\StaticOptions;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Http\Requests\StoreUserRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;
use Modules\User\app\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $staticOptions;
    public $crudService;
    public function __construct(CrudService $crudService, StaticOptions $staticOptions)
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-show|user-delete', ['only' => ['index']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-show', ['only' => ['show']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:user-restore', ['only' => ['restore']]);
        // $this->middleware('permission:user-trashed', ['only' => ['trashed']]);
        // $this->middleware('permission:user-forse-delete', ['only' => ['forseDelete']]);
        $this->staticOptions = $staticOptions;
        $this->crudService = $crudService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableRows = (new User())->getRowsTable();
        $objects = User::get();
        return view('user::index', compact('tableRows', 'objects'));
    }
    /**
     * Display a list of soft-deleted records.
     *
     * @return \Illuminate\View\View The view with the list of soft-deleted records.
     */
    public function trashed(Request $request)
    {
        $objects = User::onlyTrashed()->get();
        $tableRows = (new User())->getRowsTableTrashed();
        return view('user::trashedIndex', compact('tableRows', 'objects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $model)
    {
        // dd($request->all());
        try {
            // $validated = $request->validated();
            $this->crudService->storeRecord($model, $request, $model->getFillable(), $model->getFiles(), 'user', 'users');

            return redirect()->route('user.index');
        } catch (ValidationException $e) {
            return redirect()
                ->route('user.create')
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $object = user::where('uuid', $id)->first();
        return view('user::edit', compact('object'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // $validated = $request->validated();
            $object = User::where('uuid', $id)->first();
            $this->crudService->updateRecord($object, $request, $object->getFillable(), $object->getFiles(), 'user', 'users');

            return redirect()->route('user.index');
        } catch (ValidationException $e) {
            return redirect()
                ->route('user.edit')
                ->withErrors($e->validator)
                ->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('uuid',$request->id)->delete();
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param int $id The ID of the user to restore.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function restore(Request $request, $id)
    {
        $object = User::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('user.index');
    }

    /**
     * Force delete a record permanently.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param int $id The ID of the record to force delete.
     * @return void
     */
    public function forceDelete($id)
    {
        $object = User::withTrashed()->findOrFail($id);
        deletePicture($object, 'users', 'picture');
        $object->forceDelete();
    }

    /**
     * Change the status (active/inactive) of a user.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $object = User::findOrFail($id);
        $object->active = !$object->active;
        $object->save();
        $message = $object->active ? trans('translation.user_message_activated') : trans('translation.user_message_inactivated');
        return response()->json(['code' => 200, 'active' => $object->active, 'message' => $message]);
    }
}
