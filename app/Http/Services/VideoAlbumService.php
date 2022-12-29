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
                "cover" => $videoAlbum->cover($videoAlbum),
                "released" => $videoAlbum->released->format('d M Y'),
                "createdAt" => $videoAlbum->created_at->format("d M Y"),
            ]);
        }

        return $videoAlbums;
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
