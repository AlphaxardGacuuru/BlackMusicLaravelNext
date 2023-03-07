<?php

namespace App\Http\Services;

use App\Models\AudioAlbum;
use Illuminate\Support\Facades\Storage;

class AudioAlbumService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAudioAlbums = AudioAlbum::all();

        $audioAlbums = [];

        foreach ($getAudioAlbums as $audioAlbum) {
            array_push($audioAlbums, [
                "id" => $audioAlbum->id,
                "username" => $audioAlbum->username,
                "name" => $audioAlbum->name,
                "cover" => $audioAlbum->cover,
                "released" => $audioAlbum->released,
                "createdAt" => $audioAlbum->created_at,
            ]);
        }

        return $audioAlbums;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return AudioAlbum::find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $aCover = $request->file('cover')->store('public/audio-album-covers');
            $aCover = substr($aCover, 7);
        }

        /* Create new audio album */
        $aAlbum = new AudioAlbum;
        $aAlbum->name = $request->input('name');
        $aAlbum->username = auth('sanctum')->user()->username;
        $aAlbum->cover = $aCover;
        $aAlbum->released = $request->input('released');
        $aAlbum->save();

        return response('Audio Album Created', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('public/audio-album-covers');
			// Format for saving in DB
            $cover = substr($cover, 7);

            // Get old cover and delete it
            $oldCover = AudioAlbum::where('id', $id)->first()->cover;

            $oldCover = substr($oldCover, 9);

            Storage::disk("public")->delete($oldCover);
        }

        /* Find new audio album */
        $aAlbum = AudioAlbum::find($id);

        if ($request->filled('name')) {
            $aAlbum->name = $request->input('name');
        }

        if ($request->hasFile('cover')) {
            $aAlbum->cover = $cover;
        }

        if ($request->filled('released')) {
            $aAlbum->released = $request->input('released');
        }

        $aAlbum->save();

        return response('Audio Album Edited', 200);
    }
}
