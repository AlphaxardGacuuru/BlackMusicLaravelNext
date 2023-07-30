<?php

namespace App\Http\Controllers;

use App\Events\PostLikedEvent;
use App\Http\Services\PostLikeService;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct(protected PostLikeService $service)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        [$canDispatch, $message, $postLike] = $this->service->store($request);

        PostLikedEvent::dispatchIf(
            $canDispatch,
            $postLike->post,
            $postLike->user
        );

        return response([
            "message" => $message,
            "data" => $postLike,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function show(PostLike $postLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostLike $postLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostLike $postLike)
    {
        //
    }
}
