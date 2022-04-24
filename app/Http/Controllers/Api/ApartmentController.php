<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentFAResource;
use App\Http\Resources\ApartmentFOResource;
use App\Http\Resources\PlaceResource;
use App\Models\Apartment;
use App\Models\Image;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ApartmentController extends Controller


{

    public function forAnyone(Request $request)
    {

        $apartments = Apartment::whenPlaceId(request()->place_id)
            ->WhenApproveState(1)
            ->whenState(1)
            ->orderBy('created_at')->Paginate(10);

        $favoritesByAuthUserApartments = DB::table('user_favourite_apartment')->where('user_id', auth()->id())->get();
        foreach ($favoritesByAuthUserApartments as $FApartment) {
            foreach ($apartments as $apartment) {
                if ($apartment->id == $FApartment->apartment_id) {
                    $apartment['in_favourite'] = 1;
                }
            }

        }
        $data['apartments'] = ApartmentFAResource::collection($apartments)->response()->getData(true);
        return response()->api($data, 0, 'done');
    }//end of for anyone

    public function filter()
    {

        $max = Apartment::max('price');
        $min = Apartment::min('price');
        $places = Place::all();
        $array = [
            'places' => PlaceResource::collection($places),
            'max_price' => $max,
            'min_price' => $min];
        return response()->api($array, 1, 'done');

    }//end of filter

    public function filterData()
    {
        $range = ['max' => request()->max, 'min' => request()->min];
        $apartments = Apartment::whenPlaceId(request()->place_id)
            ->whenGender(request()->gender)
            ->whenInternet(request()->internet)
            ->whenFloor(request()->floor)
            ->whenNOR(request()->n_rooms)
            ->whenNOB(request()->n_beds)
            ->whenPrice(request()->max && request()->min ? $range : null)
            ->orderBy('price')->get(10);
        $data['apartments'] = ApartmentFAResource::collection($apartments)->response()->getData(true);
        return response()->api($data, 0, 'done');

    }//end of filter

    public function forOwner(Request $request)
    {
        $apartments = Apartment::whenPlaceId(request()->place_id)
            ->whenOwnerId(auth()->id())
            ->get();

        /* if (count($apartments) == 0) {

             return response()->api([], 0, 'There is no data');
         }*/
        return response()->api(ApartmentFOResource::collection($apartments), 0, 'donec');
    }//end of for owner

//////////////////////////// apartment ///////////////////////

    public function storeApartment(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'place_id' => 'required',
            'des' => 'nullable',
        ], $this->message());

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }
        $newApartment = Apartment::create([
            'owner_id' => auth()->id(),
            'place_id' => $request->place_id,
            'type' => $request->type,
            'internet' => $request->internet,
            'gender' => $request->gender,
            'location' => $request->location,
            'des' => $request->des,
            'price' => $request->price,
            'floor' => $request->floor,
            'n_rooms' => $request->n_rooms,
            'n_beds' => $request->n_beds,
            'n_bathroom' => $request->n_bathroom,
            'state' => 1,
            'upload_state' =>3,
        ]);

        if ($request->has('image')) {
            foreach ($request->image as $image) {
                $image->store('public/uploads/apartment_img');
                Image::create([
                    'apartment_id' => $newApartment->id,
                    'image' => $image->hashName()
                ]);
            }
        }

        return response()->api(new ApartmentFOResource($newApartment), 0, 'apartment added successfully');


    }//end of store apartment

    public function updateApartment(Request $request)
    {
        if ($request->apartment_id)
        {
            $apartment = Apartment::find($request->apartment_id);

            if ($apartment) {
                if ($apartment->owner_id == auth()->id()) {
                    $validator = Validator::make($request->all(), [
                        'place_id' => 'required',
                        'des' => 'nullable',
                    ], $this->message()
                    );
                    if ($validator->fails()) {
                        return response()->api([], 1, $validator->errors()->first());
                    }
                    $apartment->update($request->all());
                    return response()->api(new ApartmentFOResource($apartment), 0, 'the apartment updated successfully');;
                } else {
                    return response()->api([], 1, 'you cannot update this apartment');
                }
            }
            else
            {
                return response()->api([], 1, 'the apartment does not exist');
            }
        }
        else
        {
            return response()->api([], 1, 'please send apartment_id');
        }
    }//end of update apartment

    public function deleteApartment(Request $request)
    {

        if ($request->apartment_id) {
            $apartment = Apartment::find($request->apartment_id);

            if ($apartment) {
                if ($apartment->owner_id == auth()->id()) {
                    $apartment->delete();
                    return response()->api([], 0, 'the apartment deleted successfully');
                } else {

                    return response()->api([], 1, 'you cannot update this apartment');
                }
            } else {
                return response()->api([], 1, 'the apartment does not exist');
            }
        } else {
            return response()->api([], 1, 'please send apartment_id');
        }
    }//end of delete apartment

//////////////////////////////  Images   ////////////////////

    public function storeImage(Request $request)
    {

        if ($request->apartment_id && $request->has('image')) {

            $request->image->store('public/uploads/apartment_img');
            $updatedImage = Image::create([
                'apartment_id' => $request->apartment_id,
                'image' => $request->image->hashName()
            ]);

            return response()->api([], 0, 'the image add successfully');
        } else {
            return response()->api([], 1, 'please send  send image id and apartment_id');
        }

    }//end of store Image

    public function updateImage(Request $request)
    {

        if ($request->image_id && $request->apartment_id && $request->has('image')) {

            $image = Image::find($request->image_id);
            if ($image) {

                Storage::disk('local')->delete('public/uploads/apartment_img/' . $image->image);
                $image->delete();


                $request->image->store('public/uploads/apartment_img');
                $updatedImage = Image::create([
                    'apartment_id' => $request->apartment_id,
                    'image' => $request->image->hashName()
                ]);
            } else {

                return response()->api([], 1, 'image does not exist');

            }


            return response()->api([], 0, 'updatedImage');
        } else {
            return response()->api([], 1, 'please send  send image id and apartment_id');
        }

    }//end of update Image

    public function deleteImage(Request $request)
    {

        if ($request->image_id) {

            $image = Image::find($request->image_id);
            if ($image) {
                Storage::disk('local')->delete('public/uploads/apartment_img/' . $image->image);
                $image->delete();
                return response()->api([], 0, 'image deleted successfully ');
            } else {
                return response()->api([], 1, 'image does not exist');
            }
        } else {
            return response()->api([], 1, 'please send  send image id and apartment_id');
        }

    }//end of update Image

    public function toggleFavourite(Request $request)
    {
        $tt = Apartment::where('id', $request->apartment_id)->exists();
        if ($tt) {
            auth()->user()->favouriteApartments()->toggle($request->apartment_id);
            return response()->api($tt, 0, 'toggled successfully');
        }
        return response()->api($tt, 0, 'this apartment does not exists');
    }

    public function getFavourites()
    {
        $apartments = auth()->user()->favouriteApartments;
        foreach ($apartments as $co) {
            $co->in_favourite = 1;
        }
        return response()->api(ApartmentFAResource::collection($apartments), 0, 'done');
    }

    function message()
    {
        return [
            'title.required' => 'عنوان الشقه مطلوب',
            'place_id.required' => 'مكان الشقه مطلوب',
        ];
    }
}//end of controller
