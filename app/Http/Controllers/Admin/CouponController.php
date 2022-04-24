<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_coupons')->only(['index']);
        $this->middleware('permission:create_coupons')->only(['create', 'store']);
        $this->middleware('permission:update_coupons')->only(['edit', 'update']);
        $this->middleware('permission:delete_coupons')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {

        $brand = null;

        if (request()->brand_id) {
            $brand = Brand::find(request()->brand);
        }
        $categories = Category::all();

        return view('admin.coupons.index', compact('categories', 'brand'));
    }// end of index

    public function data()
    {
        $coupons = Coupon::whenBrandId(request()->brand_id)->
        whenCategoryId(request()->category_id)->with(['category'])->withCount('favouriteByUser');

        return DataTables::of($coupons)
            ->addColumn('record_select', 'admin.coupons.data_table.record_select')
            ->editColumn('created_at', function (Coupon $coupon) {
                return $coupon->created_at->format('Y-m-d');
            })
            ->editColumn('brand', function (Coupon $coupon) {
                $brand = $coupon->brand;
                return view('admin.coupons.data_table.brand', compact('brand'));
            })
            ->editColumn('category', function (Coupon $coupon) {
                $name = $coupon->category->name;
                return view('admin.coupons.data_table.category', compact('name'));
            })
            ->addColumn('actions', 'admin.coupons.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.coupons.create', compact('categories', 'brands'));

    }// end of create

    public function store(CouponRequest $request)
    {
 // return $request;
        Coupon::create([
            'title' => $request->title,
            'des' => $request->des,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'url' => $request->url,
            'code' => $request->code,

        ]);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.coupons.index');

    }// end of store

    public function edit(Coupon $coupon)
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.coupons.edit', compact('coupon', 'brands', 'categories'));

    }// end of edit

    public function update(CouponRequest $request, Coupon $coupon)
    {


        $coupon->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'title' => $request->title,
            'des' => $request->des,
            'url' => $request->url,
            'code' => $request->code,
        ]);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.coupons.index');

    }// end of update

    public function destroy(coupon $coupon)
    {
        Storage::disk('local')->delete('public/uploads/coupons/' . $coupon->image);
        $this->delete($coupon);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $coupon = coupon::FindOrFail($recordId);
            Storage::disk('local')->delete('public/uploads/coupons/' . $coupon->image);
            $this->delete($coupon);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(coupon $coupon)
    {
        $coupon->delete();

    }// end of delete
}//end of controller
