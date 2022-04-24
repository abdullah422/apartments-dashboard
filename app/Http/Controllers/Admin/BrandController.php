<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_brands')->only(['index']);
        $this->middleware('permission:create_brands')->only(['create', 'store']);
        $this->middleware('permission:update_brands')->only(['edit', 'update']);
        $this->middleware('permission:delete_brands')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {

        if (request()->ajax()) {
            $brands = Brand::where('name', 'like', '%' . request()->search . '%')
                ->limit(5)
                ->get();

            $results = [];

            $results[] = ['id' => '', 'text' => 'All Actors'];

            foreach ($brands as $brand) {

                $results[] = ['id' => $brand->id, 'text' => $brand->name];

            }//end of for each

            return json_encode($results);

        }//end of if
        return view('admin.brands.index');
    }// end of index

    public function data()
    {
        $brands = Brand::withCount(['coupons']);

        return DataTables::of($brands)
            ->addColumn('record_select', 'admin.brands.data_table.record_select')
            ->addColumn('related_coupons', 'admin.brands.data_table.related_coupons')
            ->editColumn('created_at', function (Brand $brand) {
                return $brand->created_at->format('Y-m-d');
            })
            ->editColumn('image', function (Brand $brand) {
               return view('admin.brands.data_table.image',compact('brand'));
            })
            ->addColumn('actions', 'admin.brands.data_table.actions')
            ->rawColumns(['record_select','related_coupons', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.brands.create');

    }// end of create

    public function store(brandRequest $request)
    {

        if ($request->image) {

            $request->image->store('public/uploads/brands');
            $requestData['image'] = $request->image-> hashName();
            brand::create([
                'name' => $request->name,
                'image'=> $requestData['image'],
                ]);
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.brands.index');

    }// end of store

    public function edit(brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));

    }// end of edit

    public function update(brandRequest $request, brand $brand)
    {
        $requestData = $request->validated();
        if($request->image){

            Storage::disk('local')->delete('public/uploads/brands/' . $brand->image);
            $request->image->store('public/uploads/bands');
            $requestData['image'] = $request->image->hashName();
        }

        $brand->update($requestData);


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.brands.index');
    }// end of update

    public function destroy(brand $brand)
    {
        Storage::disk('local')->delete('public/uploads/brands/' . $brand->image);
        $this->delete($brand);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $brand = brand::FindOrFail($recordId);
            Storage::disk('local')->delete('public/uploads/brands/' . $brand->image);
            $this->delete($brand);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(brand $brand)
    {
        $brand->delete();

    }// end of delete
}//end of controller
