<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable=['id','image','apartment_id'];
    protected $appends = ['image_path'];

    //att
    public function getImagePathAttribute()
    {
        return '/storage/uploads/apartment_img/'. $this->image;

    }

}
