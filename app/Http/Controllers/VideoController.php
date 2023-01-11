<?php

namespace App\Http\Controllers;

use App\Http\Services\VideoService;
use App\Models\Video;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

		return $videoService->store($request);
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
    public function charts()
    {
        return DB::table('video_likes')
            ->select('video_id', DB::raw('count(*) as likes'))
            ->groupBy('video_id')
            ->orderBy('likes', 'DESC')
            ->get();
    }
}
