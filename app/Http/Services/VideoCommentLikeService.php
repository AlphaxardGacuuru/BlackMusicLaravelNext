<?php

namespace App\Http\Services;

use App\Models\VideoCommentLike;

class VideoCommentLikeService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasLiked = VideoCommentLike::where('video_comment_id', $request->input('comment'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            VideoCommentLike::where('video_comment_id', $request->input('comment'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Like removed";
        } else {
            $videoCommentLike = new VideoCommentLike;
            $videoCommentLike->video_comment_id = $request->input('comment');
            $videoCommentLike->username = auth('sanctum')->user()->username;
            $videoCommentLike->save();

            $message = "Comment liked";

            // Show notification
            // $videoComment = VideoComment::where('id', $request->input('comment'))->first();
            // $video = $videoComment->videos;
            // $video->users->username != auth()->user()->username &&
            // $video->users->notify(new VideoCommentLikeNotifications($video->name));
        }

        return response($message, 200);
    }
}