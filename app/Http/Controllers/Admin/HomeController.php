<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Image;
use App\Models\Place;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');

    }// end of index


    public function topStatistics()
    {
        $UsersCount = number_format( User::where('type','user')->count(),1);
        $ownersCount = number_format( User::where('type','owner')->count(),1);
        $placesCount = number_format( Place::count(),1);
        $approvedCount = number_format( Apartment::WhenApproveState(1)->count(),1);
        $waitingCount = number_format( Apartment::WhenApproveState(3)->count(),1);
        $unapprovedCount = number_format( Apartment::WhenApproveState(2)->count(),1);
        $availableCount = number_format( Apartment::whenState(1)->count(),1);
        $unavailableCount = number_format( Apartment::whenState(2)->count(),1);
        $imagesCount = number_format(Image::count(),1);

        return response()->json([
            'users_count' => $UsersCount,
            'owners_count' => $ownersCount,
            'places_count' => $placesCount,
            'approved_count'=>$approvedCount,
            'waiting_count'=>$waitingCount,
            'unapproved_count'=>$unapprovedCount,
            'available_count'=>$availableCount,
            'unavailable_count'=>$unavailableCount,
            'images_count'=>$imagesCount,
        ]);

    }// end of topStatistics

}//end of controller
