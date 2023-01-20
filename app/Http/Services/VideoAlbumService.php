<?php

namespace App\Http\Services;

use App\Models\VideoAlbum;
use Illuminate\Support\Facades\Storage;

class VideoAlbumService
{
    // Get Video Albums
    public function index()
    {
        $getVideoAlbums = VideoAlbum::all();

        $videoAlbums = [];

        foreach ($getVideoAlbums as $videoAlbum) {
            array_push($videoAlbums, [
                "id" => $videoAlbum->id,
                "username" => $videoAlbum->username,
                "name" => $videoAlbum->name,
                "cover" => $videoAlbum->cover,
                "released" => $videoAlbum->released,
                "createdAt" => $videoAlbum->created_at,
            ]);
        }

        return $videoAlbums;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return VideoAlbum::find($id);
    }

	public function store($request)
	{
        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $vCover = $request->file('cover')->store('public/video-album-covers');
            $vCover = substr($vCover, 7);
        }

        /* Create new video album */
        $vAlbum = new VideoAlbum;
        $vAlbum->name = $request->input('name');
        $vAlbum->username = auth('sanctum')->user()->username;
        $vAlbum->cover = $vCover;
        $vAlbum->released = $request->input('released');;
        $vAlbum->save();

        return response('Video Album Created', 200);
	}

	public function update($request, $id)
	{
        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $vCover = $request->file('cover')->store('public/video-album-covers');
            $vCover = substr($vCover, 7);
            Storage::delete('public/' . VideoAlbum::where('id', $id)->first()->cover);
        }

        /* Create new video album */
        $vAlbum = VideoAlbum::find($id);

        if ($request->filled('name')) {
            $vAlbum->name = $request->input('name');
        }

        if ($request->hasFile('cover')) {
            $vAlbum->cover = $vCover;
        }

        if ($request->filled('released')) {
            $vAlbum->released = $request->input('released');;
        }

        $vAlbum->save();

        return response('Video Album Edited', 200);
	}
}
