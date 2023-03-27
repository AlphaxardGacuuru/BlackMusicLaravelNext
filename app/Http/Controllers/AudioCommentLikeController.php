<?php

namespace App\Http\Controllers;

use App\Events\AudioCommentLikedEvent;
use App\Http\Services\AudioCommentLikeService;
use App\Models\Audio;
use App\Models\AudioComment;
use App\Models\AudioCommentLike;
use Illuminate\Http\Request;

class AudioCommentLikeController extends Controller
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
    public function store(Request $request, AudioCommentLikeService $service)
    {
        $result = $service->store($request);

		// $comment = AudioComment::find($request->input("comment"));
		$comment = AudioComment::where("id", $request->input("comment"))->get()->first();

		// $audio = Audio::find($comment->id);
		$audio = Audio::where("id", $comment->id)->get()->first();

		AudioCommentLikedEvent::dispatchIf($result[0], $comment, $audio);

        return response($result[1], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioCommentLike  $audioCommentLike
     * @return \Illuminate\Http\Response
     */
    public function show(AudioCommentLike $audioCommentLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioCommentLike  $audioCommentLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AudioCommentLike $audioCommentLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AudioCommentLike  $audioCommentLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(AudioCommentLike $audioCommentLike)
    {
        //
    }
}
