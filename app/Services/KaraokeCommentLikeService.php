<?php

namespace App\Services;

use App\Models\KaraokeCommentLike;

class KaraokeCommentLikeService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasLiked = KaraokeCommentLike::where('karaoke_comment_id', $request->input('comment'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            KaraokeCommentLike::where('karaoke_comment_id', $request->input('comment'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Like removed";
        } else {
            $karaokeCommentLike = new KaraokeCommentLike;
            $karaokeCommentLike->karaoke_comment_id = $request->input('comment');
            $karaokeCommentLike->username = auth('sanctum')->user()->username;
            $karaokeCommentLike->save();

            $message = "Comment liked";

            // Show notification
            // $karaokeComment = KaraokeComments::where('id', $request->input('comment'))->first();
            // $karaoke = $karaokeComment->karaokes;
            // $karaoke->users->username != auth()->user()->username &&
            // $karaoke->users->notify(new KaraokeCommentLikeNotifications($karaoke->name));
        }

        return response($message, 200);
    }
}
