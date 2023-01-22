<?php

namespace App\Http\Controllers;

use App\Http\Services\PostLikeService;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
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
    public function store(Request $request, PostLikeService $postLikeService)
    {
        return $postLikeService->store($request);
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
