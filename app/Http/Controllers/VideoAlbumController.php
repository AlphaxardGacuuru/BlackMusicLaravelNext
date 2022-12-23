<?php

namespace App\Http\Controllers;

use App\Models\VideoAlbum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Video Albums
        $getVideoAlbums = VideoAlbum::all();

        $videoAlbums = [];

        foreach ($getVideoAlbums as $key => $videoAlbum) {
            array_push($videoAlbums, [
                "id" => $videoAlbum->id,
                "username" => $videoAlbum->username,
                "name" => $videoAlbum->name,
                "cover" => "/storage/" . $videoAlbum->cover,
                "released" => $videoAlbum->released,
                "createdAt" => $videoAlbum->created_at->format("d M Y"),
            ]);
        }

        return $videoAlbums;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cover' => 'required|image|max:1999',
        ]);

        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $vCover = $request->file('cover')->store('public/video-album-covers');
            $vCover = substr($vCover, 7);
        }

        // Format Released date
        $released = $request->input('released');
        $released = Carbon::parse($released);

        /* Create new video album */
        $vAlbum = new VideoAlbum;
        $vAlbum->name = $request->input('name');
        $vAlbum->username = auth()->user()->username;
        $vAlbum->cover = $vCover;
        $vAlbum->released = $released;
        $vAlbum->save();

        return response('Video Album Created', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoAlbum  $videoAlbum
     * @return \Illuminate\Http\Response
     */
    public function show(VideoAlbum $videoAlbum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoAlbum  $videoAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cover' => 'nullable|image|max:1999',
        ]);

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
			// Format Released date
            $released = $request->input('released');
            $released = Carbon::parse($released);

            $vAlbum->released = $released;
        }

        $vAlbum->save();

        return response('Video Album Edited', 200);
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
