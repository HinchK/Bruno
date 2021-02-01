<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagApiController extends Controller
{

    public function scorecards($id)
    {
        $tag = Tag::find($id);
        $scorecards = $tag->scorecards()->with('golfer', 'category', 'course', 'images', 'videos', 'comments')->orderBy('id', 'desc')->paginate();
        return ScorecardResource::collection($scorecards);
    }
}
