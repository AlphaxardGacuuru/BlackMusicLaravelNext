<?php

namespace App\Services;

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
        $hasLiked = PostCommentLike::where('post_comment_id', $request->input('comment'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            PostCommentLike::where('post_comment_id', $request->input('comment'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = 'Like removed';
            $added = false;
        } else {
            $postCommentLikes = new PostCommentLike;
            $postCommentLikes->post_comment_id = $request->input('comment');
            $postCommentLikes->username = auth('sanctum')->user()->username;
            $postCommentLikes->save();

            $message = 'Comment liked';
            $added = true;
        }

        return [$added, $message];
    }
}
