<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment'   => 'required',
            'id'   => 'required'
        ]);
        $comment = new Comment();
        $comment->comment = $request->get('comment');
        $comment->score_id =  $request->get('id');
        $comment->golfer_id = $request->user()->id;
        $comment->save();
        return new CommentResource($comment);
    }
}
