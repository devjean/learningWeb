<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function show($videoId)
    {
        $user = auth()->user();
        $hasLiked = $user->likes()->where('video_id', $videoId)->exists();
        $likesCount = Like::where('video_id', $videoId)->count();

        return response()->json(['has_liked' => $hasLiked, 'likes_count' => $likesCount]);
    }

    public function store($videoId)
    {
        $user = auth()->user();
        
        if ($user->likes()->where('video_id', $videoId)->exists()) {
            return response()->json(['message' => 'Ya has dado like a este video.'], 400);
        }

        $like = new Like();
        $like->video_id = $videoId;
        $like->user_id = $user->id;
        $like->save();

        return response()->json(['message' => 'Like añadido.']);
    }
}
