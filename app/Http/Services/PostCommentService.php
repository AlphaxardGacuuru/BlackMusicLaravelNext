<?php

namespace App\Http\Services;

use App\Models\PostComment;

class PostCommentService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        $getComments = PostComment::orderby('id', 'DESC')->get();

        $comments = [];

        foreach ($getComments as $comment) {

            array_push($comments, [
                "id" => $comment->id,
                "post_id" => $comment->post_id,
                "name" => $comment->user->name,
                "username" => $comment->user->username,
                "decos" => $comment->user->decos->count(),
                "avatar" => $comment->user->avatar,
                "text" => $comment->text,
                "likes" => $comment->likes->count(),
                "hasLiked" => $comment->hasLiked($authUsername),
                "created_at" => $comment->created_at,
            ]);
        }

        return $comments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        /* Create new comment */
        $postComment = new PostComment;
        $postComment->post_id = $request->input('id');
        $postComment->username = auth('sanctum')->user()->username;
        $postComment->text = $request->input('text');
        $postComment->media = null;

        return $postComment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostComments  $postComments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PostComment::find($id)->delete();

        return response("Comment deleted", 200);
    }

}
