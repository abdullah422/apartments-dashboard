<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','image','index'];


    protected $appends = ['image_path'];

    //att
    public function getImagePathAttribute()
    {
        return '/storage/uploads/brands/'. $this->image;

    }



    //scope
    //rel
    public function coupons(){
        return $this->hasMany(Coupon::class);
    }
    //fun

}
