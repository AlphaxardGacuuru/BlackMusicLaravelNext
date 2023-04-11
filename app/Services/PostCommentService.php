<?php

namespace App\Services;

use App\Models\PostComment;

class PostCommentService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getComments = PostComment::orderby('id', 'DESC')->get();

        $comments = [];

        foreach ($getComments as $comment) {
            array_push($comments, $this->structure($comment));
        }

        return $comments;
    }

    /**
     * Display a specific resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getComments = PostComment::where("post_id", $id)->orderby('id', 'DESC')->get();

        $comments = [];

        foreach ($getComments as $comment) {

            array_push($comments, $this->structure($comment));
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

        $saved = $postComment->save();

        return ["saved" => $saved, "comment" => $postComment];
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

    /*
     *
     * Structure for a Post Comment
     */
    public function structure($comment)
    {
        return [
            "id" => $comment->id,
            "post_id" => $comment->post_id,
            "name" => $comment->user->name,
            "username" => $comment->user->username,
            "decos" => $comment->user->decos->count(),
            "avatar" => $comment->user->avatar,
            "text" => $comment->text,
            "likes" => $comment->likes->count(),
            "hasLiked" => $comment->hasLiked($this->username),
            "created_at" => $comment->created_at,
        ];
    }
}
