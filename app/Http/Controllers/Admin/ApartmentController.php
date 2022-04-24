<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApartmentRequest;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Place;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Type;
use Yajra\DataTables\DataTables;

class ApartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_apartments')->only(['index']);
        $this->middleware('permission:create_apartments')->only(['create', 'store']);
        $this->middleware('permission:update_apartments')->only(['edit', 'update']);
        $this->middleware('permission:delete_apartments')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $places = Place::all();

        return view('admin.apartments.index', compact('places'));
    }// end of index

    public function data()
    {
        $apartments = Apartment::whenPlaceId(request()->place_id)
            ->WhenApproveState(request()->approveState)
            ->whenState(request()->state)
            ->with(['place'])->with('images');
        return DataTables::of($apartments)

            ->editColumn('created_at', function (Apartment $apartment) {
                return $apartment->created_at->format('Y-m-d');
            })
            ->editColumn('owner', function (Apartment $apartment) {
                $user =User::find($apartment->owner_id);
                $name = $user->name;
                return view('admin.apartments.data_table.place', compact('name'));
            })
            ->editColumn('place', function (Apartment $apartment) {
                $name = $apartment->place->name;
                return view('admin.apartments.data_table.place', compact('name'));
            })
            ->editColumn('type', function (Apartment $apartment) {
                $type = $apartment->type;
                return view('admin.apartments.data_table.type', compact('type'));
            })
            ->editColumn('state', function (Apartment $apartment) {
                $state = $apartment->state;
                return view('admin.apartments.data_table.state', compact('state'));
            })
            ->editColumn('upload_state', function (Apartment $apartment) {
                $upload_state = $apartment->upload_state;
                return view('admin.apartments.data_table.upload_state', compact('upload_state'));
            })
            ->addColumn('record_select', 'admin.apartments.data_table.record_select')
            ->addColumn('images', 'admin.apartments.data_table.images')
            ->addColumn('actions', 'admin.apartments.data_table.actions')
            ->rawColumns(['record_select', 'actions','images'])
            ->toJson();

    }// end of data

    public function create()
    {
        $places = Place::all();
        return view('admin.apartments.create', compact('places'));
    }// end of create

    public function store(ApartmentRequest $request)
    {
        $newApartment = Apartment::create([
            'owner_id' => auth()->id(),
            'place_id' => $request->place_id,
            'type' => $request->type,
            'location' => $request->location,
            'gender' => $request->gender,
            'internet' => $request->internet,
            'floor' => $request->floor,
            'des' => $request->des,
            'price' => $request->price,
            'n_rooms' => $request->n_rooms,
            'n_beds' => $request->n_beds,
            'n_bathroom' => $request->n_bathroom,
            'state' =>1,
            'upload_state' =>1,
        ]);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $image->store('public/uploads/apartment_img');
                Image::create([
                        'apartment_id' => $newApartment->id,
                        'image' => $image->hashName()
                ]);
            }
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.apartments.index');

    }// end of store

    public function edit(Apartment $apartment)
    {
        $places = Place::all();
        return view('admin.apartments.edit', compact('apartment', 'places'));

    }// end of edit

    public function update(ApartmentRequest $request, Apartment $apartment)
    {

        $apartment->update([
            'upload_state'=>$request->upload_state,
            'state'=>$request->state,
            'type'=>$request->type,
            'place_id' => $request->place_id,
            'location' => $request->location,
            'gender' => $request->gender,
            'internet' => $request->internet,
            'floor' => $request->floor,
            'des' => $request->des,
            'price' => $request->price,
            'code' => $request->code,
            'n_rooms'=>$request->n_rooms,
            'n_beds'=>$request->n_beds,
            'n_bathroom'=>$request->n_bathroom,
        ]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.apartments.index');

    }// end of update

    public function show(Apartment $apartment){
        $apartment->load(['images']);
        return view('admin.apartments.show',compact('apartment'));
    }

    public function destroy(Apartment $apartment)
    {
        $images=$apartment->images;
        foreach ($images as $image){
            $image->delete();
            Storage::disk('local')->delete('public/uploads/apartment_img/' .$image->name);
        }
        $this->delete($apartment);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $apartment = Apartment::FindOrFail($recordId);
            $images=$apartment->images;
            foreach ($images as $image){
                $image->delete();
                Storage::disk('local')->delete('public/uploads/apartment_img/' .$image->name);
            }
            $this->delete($apartment);
        }//end of for each
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(apartment $apartment)
    {
        $apartment->delete();

    }// end of delete
}
