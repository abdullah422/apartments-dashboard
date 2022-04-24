<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\UserResource;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(Request $request)
    {

       $coupons = Coupon::whenBrandId(request()->brand_id)->whenCategoryId(request()->category_id)->Paginate(10);

        $f = DB::table('user_favourite_coupon')->where('user_id',auth()->id())->get();
        foreach($f as $fc){
           foreach($coupons as $co){
                if($co->id==$fc->coupon_id){
                 $co['in_favourite']= 1;
                }
            }

        }
       $data['coupons'] = CouponResource::collection($coupons)->response()->getData(true);

        return response()->api($data);
        //CouponResource::collection($f)
    }


    public function toggleFavourite(Request $request)
    {
        $tt = Coupon::where('id', $request->coupon_id)->exists();
        if ($tt) {
            auth()->user()->favouriteCoupons()->toggle($request->coupon_id);
            return response()->api($tt, 0, 'toggled successfully');
        }
        return response()->api($tt, 0, 'this coupon does not exists');
    }


    public function isFavourite(Request $request)
    {

        $f = DB::table('user_favourite_coupon')
            ->where('coupon_id', $request->coupon_id)
            ->where('user_id', auth()->id())->exists();

        if ($f) {
            $data['isFavourite'] = true;
            return response()->api($data, 0, 'is favourite');
        } else {
            $data['isFavourite'] = false;
            return response()->api($data, 0, 'is not favourite');
        }


    }

    public function getFavourites()
    {
        $coupons = auth()->user()->favouriteCoupons;
        foreach($coupons as $co){
            $co->in_favourite=1;
        }
        return response()->api(CouponResource::collection($coupons), 0, 'done');
    }


}//end of controller
