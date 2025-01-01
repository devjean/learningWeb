<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function show($courseId, $videoId)
    {
        $video = Video::findOrFail($videoId);

        return response()->json($video);
    }
}
