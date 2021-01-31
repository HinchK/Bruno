<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_id' => $this->id,
            'category_title' => $this->title,
            'category_color' => $this->color,
        ];
    }

    public function with($request){
        return [
            'version' => "0.0.1",
            'golfer_url' => "https://imustnotfear.net"
        ];
    }
}
