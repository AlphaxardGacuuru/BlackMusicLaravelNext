<?php

namespace App\Http\Controllers;

use App\Events\PostCommentedEvent;
use App\Http\Services\PostCommentService;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostCommentService $postCommentService)
    {
        return $postCommentService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostCommentService $postCommentService)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        $saved = $postCommentService->store($request);
		
        // Dispatch Event
		// Get post
        $post = Post::findOrFail($request->input("id"));
        
        PostCommentedEvent::dispatchif($saved, $post);

        return response("Comment sent", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostComment $postComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PostCommentService $postCommentService)
    {
        return $postCommentService->destroy($id);
    }
}
