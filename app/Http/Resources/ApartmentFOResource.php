<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentFOResource extends JsonResource
{

    public function toArray($request)
    {
        $userId = auth()->id();
        return [
            'id' => $this->id,
            'place' => new  PlaceResource($this->place),
            'owner' => new  OwnerResource($this->owner),
            'type' => intval($this->type),
            'price'=>intval($this->price),
            'n_beds' => intval($this->n_beds),
            'n_rooms' => intval($this->n_rooms),
            'n_bathroom' => intval($this->n_bathroom),
            'gender' => intval($this->gender),
            'internet' => intval($this->internet),
            'floor' => intval($this->floor),
            'description' => $this->des,
            'location' => $this->location,
            'images' => ImageResource::collection($this->images),
            'approve_state'=> intval($this->upload_state),
            'status'=> intval($this->state),
        ];
    }

}
