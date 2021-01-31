<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'golfer_id' => $this->id,
            'name' => $this->name,
            'golfer_email' => $this->email,
            'avatar' => $this->profile_photo_path,
            'token' => $this->token,
        ];
    }
}
