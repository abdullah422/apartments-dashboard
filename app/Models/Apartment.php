<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = ['id','floor','gender','internet','location', 'n_rooms', 'n_bathroom', 'n_beds', 'price', 'type', 'owner_id', 'place_id', 'type',
        'state', 'upload_state', 'des'];



    //scope

    public function scopeWhenPlaceId($query, $placeId)
    {
        return $query->when($placeId, function ($q) use ($placeId) {

            return $q->whereHas('place', function ($qu) use ($placeId) {

                return $qu->where('places.id', $placeId);
            });

        });

    }
    public function scopeWhenOwnerId($query, $ownerId)
    {
        return $query->when($ownerId, function ($q) use ($ownerId) {

            return $q->whereHas('owner', function ($qu) use ($ownerId) {

                return $qu->where('users.id', $ownerId);
            });

        });

    }

    public function scopeWhenGender($query, $gender)
    {
        return $query->when($gender, function ($q) use ($gender) {

            return $q->where('gender',$gender);
        });

    }

    public function scopeWhenInternet($query, $internet)
    {
        return $query->when($internet, function ($q) use ($internet) {

            return $q->where('internet',$internet);
        });

    }

    public function scopeWhenFloor($query, $floor)
    {
        return $query->when($floor, function ($q) use ($floor) {

            return $q->where('floor',$floor);
        });

    }
    public function scopeWhenNOR($query, $n_rooms)
    {
        return $query->when($n_rooms, function ($q) use ($n_rooms) {

            return $q->where('n_rooms',$n_rooms);
        });

    }
    public function scopeWhenNOB($query, $n_beds)
    {
        return $query->when($n_beds, function ($q) use ($n_beds) {

            return $q->where('n_beds',$n_beds);
        });

    }

    public function scopeWhenPrice($query,$range)
    {
        return $query->when($range, function ($q) use ($range) {

            return $q->whereBetween('price', [$range['min'],$range['max']]);
        });

    }
    public function scopeWhenState($query, $state)
    {
        return $query->when($state, function ($q) use ($state) {

            return $q->where('state',$state);
        });

    }
    public function scopeWhenApproveState($query, $approveState)
    {
        return $query->when($approveState, function ($q) use ($approveState) {

            return $q->where('upload_state',$approveState);
        });

    }

    //relation
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }
    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function favouriteByUser(){

        return  $this->belongsToMany(User::class,'user_favourite_apartment','apartment_id','user_id');
    }

}
