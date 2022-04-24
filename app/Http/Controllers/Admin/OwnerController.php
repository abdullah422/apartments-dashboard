<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OwnerRequest;
use App\Models\Role;
use App\Models\User;
use Yajra\DataTables\DataTables;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_owners')->only(['index']);
        $this->middleware('permission:create_owners')->only(['create', 'store']);
        $this->middleware('permission:update_owners')->only(['edit', 'update']);
        $this->middleware('permission:delete_owners')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $roles = Role::whereNotIn('name', ['super_admin','owner','user'])->get();
        return view('admin.owners.index', compact('roles'));

    }// end of index

    public function data()
    {
        $owners = User::whenType('owner')
            ->whenRoleId(request()->role_id);

        return DataTables::of($owners)
            ->addColumn('record_select', 'admin.owners.data_table.record_select')->
            editColumn('image', function (User $owner) {
                return view('admin.owners.data_table.image', compact('owner'));
            })
            ->editColumn('created_at', function (User $owner) {
                return $owner->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.owners.data_table.actions')
            ->rawColumns(['record_select', 'roles', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
      /*  $roles = Role::whereNotIn('name', ['super_admin', 'admin','owner','user'])->get();*/

        return view('admin.owners.create');

    }// end of create

    public function store(OwnerRequest $request)
    {
        $requestData = $request->validated();
        $requestData['password'] = bcrypt($request->password);

        User::create($requestData);
        //$owner->attachRoles(['owner', $request->role_id]);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.owners.index');

    }// end of store

    public function edit(User $owner)
    {
        return view('admin.owners.edit', compact('owner'));

    }// end of edit

    public function update(OwnerRequest $request, User $owner)
    {
        $owner->update($request->validated());


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.owners.index');

    }// end of update

    public function destroy(User $owner)
    {
        $this->delete($owner);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $owner = User::FindOrFail($recordId);
            $this->delete($owner);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(User $owner)
    {
        $owner->delete();

    }// end of delete

}//end of controller
