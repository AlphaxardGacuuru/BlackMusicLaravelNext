<?php

namespace App\Http\Services;

use App\Models\VideoLike;

class VideoLikeService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasLiked = VideoLike::where('video_id', $request->input('video'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            VideoLike::where('video_id', $request->input('video'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Like removed";
        } else {
            $videoLike = new VideoLike;
            $videoLike->video_id = $request->input('video');
            $videoLike->username = auth('sanctum')->user()->username;
            $videoLike->save();

            $message = "Video liked";

            // Show notification
            // $video = Videos::where('id', $request->input('video'))->first();
            // $video->users->username != auth()->user()->username &&
            // $video->users->notify(new VideoLikeNotifications($video->name));
        }

        return response($message, 200);
    }
}
