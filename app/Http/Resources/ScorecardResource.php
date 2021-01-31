<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScorecardResource extends JsonResource
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
            'score_id' => $this->id,
            'score_title' => $this->title,
            'score_content' => $this->content,
            'score_type' => $this->score_type,
            'score_meta' => $this->meta_data,
            'score' => $this->score,
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y'),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'golfer' => new UserResource($this->whenLoaded('golfer')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
