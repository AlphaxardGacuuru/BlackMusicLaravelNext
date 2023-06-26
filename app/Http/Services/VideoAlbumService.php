<?php

namespace App\Http\Services;

use App\Models\VideoAlbum;
use Illuminate\Support\Facades\Storage;

class VideoAlbumService extends Service
{
    // Get Video Albums
    public function index()
    {
        $getVideoAlbums = VideoAlbum::all();

        $videoAlbums = [];

        foreach ($getVideoAlbums as $videoAlbum) {
            array_push($videoAlbums, $this->structure($videoAlbum));
        }

        return $videoAlbums;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoAlbum  $videoAlbum
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
        $vAlbum->released = $request->input('released');
        $vAlbum->save();

        return response('Video Album Created', 200);
    }

    public function update($request, $id)
    {
        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('public/video-album-covers');
            // Format for saving in DB
            $cover = substr($cover, 7);

            $oldCover = VideoAlbum::where('id', $id)->first()->cover;

            $oldCover = substr($oldCover, 9);

            Storage::disk("public")->delete($oldCover);
        }

        /* Create new video album */
        $vAlbum = VideoAlbum::find($id);

        if ($request->filled('name')) {
            $vAlbum->name = $request->input('name');
        }

        if ($request->hasFile('cover')) {
            $vAlbum->cover = $cover;
        }

        if ($request->filled('released')) {
            $vAlbum->released = $request->input('released');
        }

        $vAlbum->save();

        return response('Video Album Edited', 200);
    }

    /*
     * Artist's Video Albums */
    public function artistVideoAlbums($username)
    {
        $getArtistVideoAlbums = VideoAlbum::where("username", $username)->get();

        $artistVideoAlbums = [];

        foreach ($getArtistVideoAlbums as $videoAlbum) {
            array_push($artistVideoAlbums, $this->structure($videoAlbum));
        }

        return $artistVideoAlbums;
    }

    /*
     * Album Structure*/
    public function structure($videoAlbum)
    {
        return [
            "id" => $videoAlbum->id,
            "username" => $videoAlbum->username,
            "name" => $videoAlbum->name,
            "cover" => $videoAlbum->cover,
            "released" => $videoAlbum->released,
            "createdAt" => $videoAlbum->created_at,
        ];
    }
}
