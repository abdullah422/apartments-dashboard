<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Framework\Constraint\IsEmpty;
use function PHPUnit\Framework\isEmpty;

class ApartmentFAResource extends JsonResource
{

    public function toArray($request)
    {
        $userId = auth()->id();


        return [
            'id' => $this->id,
            'place' => new  PlaceResource($this->place),
            'owner' => new  OwnerResource($this->owner),
            'type' => intval($this->type),
            'price' => intval($this->price),
            'n_beds' => $this->n_beds,
            'n_rooms' => $this->n_rooms,
            'n_bathroom' => $this->n_bathroom,
            'gender' => intval($this->gender),
            'internet' => intval($this->internet),
            'floor' => intval($this->floor),
            'description' => $this->des,
            'location' => $this->location,
            'images' => ImageResource::collection($this->images),
            'in_favourite' => $this->in_favourite == 1 ? true : false,
        ];
    }

}
