<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['id','title','des','index','type','category_id','brand_id','code','in_favourite','url'];

    protected $appends = ['image_path'];

    //att
    public function getImagePathAttribute()
    {
        return '/storage/uploads/coupons/'. $this->image;

    }


    //scope

    public function scopeWhenCategoryId($query, $categoryId)
    {
        return $query->when($categoryId, function ($q) use ($categoryId) {

            return $q->whereHas('category', function ($qu) use ($categoryId) {

                return $qu->where('categories.id', $categoryId);

            });

        });

    }
    public function scopeWhenBrandId($query, $branchId)
    {
        return $query->when($branchId, function ($q) use ($branchId) {

            return $q->whereHas('brand', function ($qu) use ($branchId) {

                return $qu->where('brands.id', $branchId);
            });

        });

    }
    //rel
    public function favouriteByUser(){

       return  $this->belongsToMany(User::class,'user_favourite_coupon','coupon_id','user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
       // return $this->belongsToMany(Genre::class, 'movie_genre');

    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    //fun
}
