<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_banners')->only(['index']);
        $this->middleware('permission:create_banners')->only(['create', 'store']);
        $this->middleware('permission:update_banners')->only(['edit', 'update']);
        $this->middleware('permission:delete_banners')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index(){


        return view ('admin.banners.index');
    }

    public function data()
    {
        $banners = Banner::select();

        return DataTables::of($banners)
            ->addColumn('record_select', 'admin.banners.data_table.record_select')
            ->editColumn('created_at', function (Banner $banner) {
                return $banner->created_at->format('Y-m-d');
            })
            ->editColumn('image', function (Banner $banner) {
                return view('admin.banners.data_table.image',compact('banner'));
            })
            ->addColumn('actions', 'admin.banners.data_table.actions')
            ->rawColumns(['record_select','related_coupons', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.banners.create');

    }// end of create

    public function store(BannerRequest $request)
    {

        if ($request->image) {

            $request->image->store('public/uploads/banners');
            $requestData['image'] = $request->image-> hashName();
            banner::create([
                'name' => $request->name,
                'image'=> $requestData['image'],
            ]);
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.banners.index');

    }// end of store

    public function edit(banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));

    }// end of edit

    public function update(BannerRequest $request, Banner $banner)
    {

        $requestData = $request->validated();
        if($request->image){

            Storage::disk('local')->delete('public/uploads/banners/' . $banner->image);
            $request->image->store('public/uploads/banners');
            $requestData['image'] = $request->image->hashName();
        }

        $banner->update($requestData);


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.banners.index');

    }// end of update

    public function destroy(Banner $banner)
    {
        Storage::disk('local')->delete('public/uploads/banners/' . $banner->image);
        $this ->delete($banner);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $banner = Banner::FindOrFail($recordId);
            Storage::disk('local')->delete('public/uploads/banners/' . $banner->image);
            $this->delete($banner);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(Banner $banner)
    {
        $banner->delete();

    }// end of delete
}
