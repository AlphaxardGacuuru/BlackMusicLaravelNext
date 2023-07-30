<?php

namespace App\Http\Services;

use App\Models\PostLike;

class PostLikeService extends Service
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $query = PostLike::where('post_id', $request->input('post'))
            ->where('username', auth('sanctum')->user()->username);

        $hasLiked = $query->exists();

        if ($hasLiked) {
            // Get like
            $postLike = $query->first();
            // Delete
            $query->delete();
            // Set Message
            $message = "Like removed";
            $added = false;
        } else {
            $postLike = new PostLike;
            $postLike->post_id = $request->input('post');
            $postLike->username = auth('sanctum')->user()->username;
            $postLike->save();

            $message = "Post liked";
            $added = true;
        }

        // Check if current user is owner of post
        $notCurrentUser = $postLike->post->username != $this->username;
        // Dispatch if comment is saved successfully and current user is not owner of audio
        $canDispatch = $notCurrentUser && $added;

        return [$canDispatch, $message, $postLike];
    }
}
