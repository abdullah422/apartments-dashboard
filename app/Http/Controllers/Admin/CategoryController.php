<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\categoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_categories')->only(['index']);
        $this->middleware('permission:create_categories')->only(['create', 'store']);
        $this->middleware('permission:update_categories')->only(['edit', 'update']);
        $this->middleware('permission:delete_categories')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.categories.index');

    }// end of index

    public function data()
    {
        $categories = category::withCount(['coupons']);

        return DataTables::of($categories)
            ->addColumn('record_select', 'admin.categories.data_table.record_select')
            ->addColumn('related_coupons', 'admin.categories.data_table.related_coupons')
            ->editColumn('created_at', function (category $category) {
                return $category->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.categories.data_table.actions')
            ->rawColumns(['record_select','actions','related_coupons'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.categories.create');

    }// end of create

    public function store(categoryRequest $request)
    {
        $category = category::create($request->only(['name']));
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.categories.index');

    }// end of store

    public function edit(category $category)
    {
        return view('admin.categories.edit', compact('category'));

    }// end of edit

    public function update(categoryRequest $request, category $category)
    {
        $category->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.categories.index');

    }// end of update

    public function destroy(category $category)
    {
        $this->delete($category);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $category = category::FindOrFail($recordId);
            $this->delete($category);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(category $category)
    {
        $category->delete();

    }// en
}
