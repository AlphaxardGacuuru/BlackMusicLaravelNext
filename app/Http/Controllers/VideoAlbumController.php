<?php

namespace App\Http\Controllers;

use App\Models\VideoAlbum;
use App\Services\VideoAlbumService;
use Illuminate\Http\Request;

class VideoAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VideoAlbumService $videoAlbumService)
    {
        return $videoAlbumService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, VideoAlbumService $videoAlbumService)
    {
        $this->validate($request, [
            'cover' => 'required|image|max:1999',
        ]);

        return $videoAlbumService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoAlbum  $videoAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id, VideoAlbumService $videoAlbumService)
    {
        return $videoAlbumService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoAlbum  $videoAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, VideoAlbumService $videoAlbumService)
    {
        $this->validate($request, [
            'cover' => 'nullable|image|max:1999',
        ]);

        return $videoAlbumService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VideoAlbum  $videoAlbum
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoAlbum $videoAlbum)
    {
        //
    }
}
