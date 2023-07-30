<?php

namespace App\Http\Services;

use App\Models\PostCommentLike;

class PostCommentLikeService extends Service
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $query = PostCommentLike::where('post_comment_id', $request->input('comment'))
            ->where('username', auth('sanctum')->user()->username);

        $hasLiked = $query->exists();

        if ($hasLiked) {
            // Get Like
            $postCommentLike = $query->first();
            // Delete Like
            $query->delete();
            // Set Message
            $message = 'Like removed';
            $added = false;
        } else {
            $postCommentLike = new PostCommentLike;
            $postCommentLike->post_comment_id = $request->input('comment');
            $postCommentLike->username = auth('sanctum')->user()->username;
            $postCommentLike->save();

            $message = 'Comment liked';
            $added = true;
        }

        // Check if current user is owner of post
        $notCurrentUser = $postCommentLike->comment->username != $this->username;
        // Dispatch if comment is saved successfully and current user is not owner of audio
        $canDispatch = $notCurrentUser && $added;

        return [$canDispatch, $message, $postCommentLike];
    }
}
