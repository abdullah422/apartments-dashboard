<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userId = auth()->id();


        return [
            'id' => $this->id,
            'category' => new  CategoryResource($this->category),
            'brand' => new  BrandResource($this->brand),
            'title' => $this->title,
            'description' => $this->des,
            'code'=>$this->code,
            'type' => $this->type,
            'url'=>$this->url,
            'in_favourite' => $this->in_favourite,
        ];
    }

    /*public function ff(){
        $user  =auth()->user();
        $userId= $user->id;
        $gg =\DB::table('user_favourite_coupon')->when('user_id',equalTo($userId))->get();
        return $gg;




    }*/
}
