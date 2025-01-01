<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index($videoId)
    {
        $comments = $this->getComments($videoId);
        return response()->json($comments);
    }

    public function store(Request $request, $videoId)
    {
        $user = auth()->user();
        $comment = new Comment();
        $comment->video_id = $videoId;
        $comment->user_id = $user->id;
        $comment->content = $request->comment;
        $comment->save();

        $comments = $this->getComments($videoId);
        
        return response()->json($comments);
    }

    public function getComments($videoId){
        return Comment::where('video_id', $videoId)->with('user')->orderBy('id', 'desc')->get();
    }
}
