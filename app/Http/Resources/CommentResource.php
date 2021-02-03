<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment_id' => $this->id,
            'comment' => $this->comment,
            'golfer_id' => new UserResource($this->whenLoaded('golfer_id')),
            'scorecard' => new ScorecardResource($this->whenLoaded('scorecard')),
        ];
    }
}
