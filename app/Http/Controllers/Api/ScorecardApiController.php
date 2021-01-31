<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ScorecardResource;
use App\Models\Scorecard;
use Illuminate\Http\Request;

class ScorecardApiController extends Controller
{
    public function index()
    {
        $scorecards = Scorecard::with(['golfer', 'category', 'tags', 'images', 'videos', 'comments'])->paginate();
        return ScorecardResource::collection($scorecards);
    }

    public function show($id)
    {
        $scorecard = Scorecard::with([
            'golfer', 'category', 'tags', 'images', 'videos', 'comments' ,'score' => function ($query) {
                $query->with(['author']);
            }
        ])->find($id);
        return new ScorecardResource($scorecard);
    }

    public function comments($id)
    {
        $scorecard = Scorecard::find($id);
        $comments = $scorecard->comments->all();
        return CommentResource::collection($comments);
    }
}
