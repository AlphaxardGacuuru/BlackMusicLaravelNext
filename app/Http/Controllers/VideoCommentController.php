<?php

namespace App\Http\Controllers;

use App\Events\VideoCommentedEvent;
use App\Models\Video;
use App\Models\VideoComment;
use App\Services\VideoCommentService;
use Illuminate\Http\Request;

class VideoCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VideoCommentService $videoCommentService)
    {
        return $videoCommentService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, VideoCommentService $videoCommentService)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        $saved = $videoCommentService->store($request);

        $video = Video::find($request->input("id"));

        VideoCommentedEvent::dispatchIf($saved, $video);

        return response("Comment saved", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoComment  $videoComment
     * @return \Illuminate\Http\Response
     */
    public function show($id, VideoCommentService $videoCommentService)
    {
        return $videoCommentService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoComment  $videoComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoComment $videoComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VideoComment  $videoComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, VideoCommentService $videoCommentService)
    {
        return $videoCommentService->destroy($id);
    }
}
