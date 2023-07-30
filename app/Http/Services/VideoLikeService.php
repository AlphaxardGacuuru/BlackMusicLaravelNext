<?php

namespace App\Http\Services;

use App\Models\VideoLike;

class VideoLikeService extends Service
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $query = VideoLike::where('video_id', $request->input('video'))
            ->where('username', auth('sanctum')->user()->username);

        $hasLiked = $query->exists();

        if ($hasLiked) {
            // Get Like
            $videoLike = $query->first();
            // Delete Like
            $query->delete();
            // Set Message
            $message = "Like removed";
            $added = false;
        } else {
            $videoLike = new VideoLike;
            $videoLike->video_id = $request->input('video');
            $videoLike->username = auth('sanctum')->user()->username;
            $videoLike->save();

            $message = "Video liked";
            $added = true;
        }

        // Check if user is owner of video
        $notCurrentUser = $videoLike->video->username != $this->username;
        // Dispatch if like is saved successfully and user is not owner of video
        $canDispatch = $notCurrentUser && $added;

        return [$canDispatch, $message, $videoLike];
    }
}
