<?php

namespace App\Http\Services;

use App\Events\AudioCommentLikedEvent;
use App\Models\AudioCommentLike;

class AudioCommentLikeService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasLiked = AudioCommentLike::where('audio_comment_id', $request->input('comment'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            AudioCommentLike::where('audio_comment_id', $request->input('comment'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Like removed";
        } else {
            $audioCommentLike = new AudioCommentLike;
            $audioCommentLike->audio_comment_id = $request->input('comment');
            $audioCommentLike->username = auth('sanctum')->user()->username;
            $audioCommentLike->save();

            $message = "Comment liked";

            // Dispatch Event
            $audioComment = AudioComment::find($request->input('comment'));
            $audio = $audioComment->audio;

			AudioCommentLikedEvent::dispatch($audio);
        }

        return response($message, 200);
    }
}
