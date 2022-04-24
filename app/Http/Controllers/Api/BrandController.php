<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function index(){

        $brands=Brand::all();
        return response()->api(BrandResource::collection($brands),0,'done');
    }
    public function brandWithCoupons(){

        $brands=Brand::with('coupons')->paginate(10);
        return response()->api(BrandResource::collection($brands),0,'done');
    }

}//end of controller
