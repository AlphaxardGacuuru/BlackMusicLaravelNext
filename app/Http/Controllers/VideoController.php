<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VideoService $videoService)
    {
        return $videoService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, VideoService $videoService)
    {
        // Handle form for video
        $this->validate($request, [
            'video' => 'required|string',
            'name' => 'required|string',
            'thumbnail' => 'required',
            'ft' => 'nullable|exists:users,username',
        ]);

        $response = $videoService->store($request);

        // VideoUploadedEvent::dispatchIf($response["saved"], $response["video"]);

        return response('Video Uploaded', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($id, VideoService $videoService)
    {
        return $videoService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, VideoService $videoService)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'ft' => 'nullable|exists:users,username',
        ]);

        return $videoService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video, $id)
    {
        //
    }

    /*
     * Display a listing of the charts.
     *
     */
    public function newlyReleased(VideoService $service)
    {
        return $service->newlyReleased();
    }

    public function trending(VideoService $service)
    {
        return $service->trending();
    }

    public function topDownloaded(VideoService $service)
    {
		return $service->topDownloaded();
    }

    public function topLiked(VideoService $service)
    {
		return $service->topLiked();
    }

	/*
	* Artist's Videos */
	public function artistVideos($username, VideoService $service)
	{
		return $service->artistVideos($username);
	} 
}
