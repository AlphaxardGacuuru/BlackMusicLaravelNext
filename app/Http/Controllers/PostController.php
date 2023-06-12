<?php

namespace App\Http\Controllers;

use App\Events\PostedEvent;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostService $postService)
    {
        return $postService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostService $postService)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        $response = $postService->store($request);

		// Dispatch event
		PostedEvent::dispatchIf($response["saved"], $response["post"]);

        return response('Post Created', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id, PostService $service)
    {
        return $service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, PostService $postService)
    {
        return $postService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PostService $postService)
    {
        return $postService->destory($id);
    }

	/*
	* Mute */
	public function mute($username, PostService $postService)
	{
		return $postService->mute($username);
	} 

    /*
     * Artist's Posts */
    public function artistPosts($username, PostService $service)
    {
        return $service->artistPosts($username);
    }
}
