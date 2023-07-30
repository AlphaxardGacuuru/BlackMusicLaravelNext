<?php

namespace App\Http\Services;

use App\Models\VideoCommentLike;

class VideoCommentLikeService extends Service
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $query = VideoCommentLike::where('video_comment_id', $request->input('comment'))
            ->where('username', auth('sanctum')->user()->username);

        $hasLiked = $query->exists();

        if ($hasLiked) {
            // Get Like
            $videoCommentLike = $query->first();
            // Delete
            $query->delete();
			// Set Message
            $message = "Like removed";
            $added = false;
        } else {
            $videoCommentLike = new VideoCommentLike;
            $videoCommentLike->video_comment_id = $request->input('comment');
            $videoCommentLike->username = auth('sanctum')->user()->username;
            $videoCommentLike->save();

            $message = "Comment liked";
            $added = true;
        }

        // Check if current user is owner of videos
        $notCurrentUser = $videoCommentLike->comment->username != $this->username;
        // Dispatch if comment is saved successfully and current user is not owner of audio
        $canDispatch = $notCurrentUser && $added;

        return [$canDispatch, $message, $videoCommentLike];
    }
}
