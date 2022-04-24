<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CouponResource;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $brands = Brand:: paginate(10);
        $categories = Category::paginate(10);
        $coupons = Coupon:: paginate(10);
        $data['banners'] = BannerResource::collection($banners);
        $data['brands'] = BrandResource::collection($brands);
        $data['categories'] = CategoryResource::collection($categories);
        $data['coupons']= CouponResource::collection($coupons);

        return response()->api($data);


    }
}
