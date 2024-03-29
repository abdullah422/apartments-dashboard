<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name'];

    //attr
    //scope
    // rel

    //fun

    public function coupons(){
        return $this->hasMany(Coupon::class);
    }
}
