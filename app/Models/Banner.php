<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['name','id','image'];

    protected $appends = ['image_path'];

    //att
    public function getImagePathAttribute()
    {
        return '/storage/uploads/banners/'. $this->image;

    }
}
