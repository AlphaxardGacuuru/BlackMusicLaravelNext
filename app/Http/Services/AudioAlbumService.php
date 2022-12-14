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
                "cover" => $audioAlbum->cover($audioAlbum),
                "released" => $audioAlbum->released->format('d M Y'),
                "createdAt" => $audioAlbum->created_at->format("d M Y"),
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
            $vCover = $request->file('cover')->store('public/audio-album-covers');
            $vCover = substr($vCover, 7);
        }

        /* Create new audio album */
        $vAlbum = new AudioAlbum;
        $vAlbum->name = $request->input('name');
        $vAlbum->username = auth('sanctum')->user()->username;
        $vAlbum->cover = $vCover;
        $vAlbum->released = $request->input('released');
        $vAlbum->save();

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
            $vCover = $request->file('cover')->store('public/audio-album-covers');
            $vCover = substr($vCover, 7);
            Storage::delete('public/' . AudioAlbum::where('id', $id)->first()->cover);
        }

        /* Create new audio album */
        $vAlbum = AudioAlbum::find($id);

        if ($request->filled('name')) {
            $vAlbum->name = $request->input('name');
        }

        if ($request->hasFile('cover')) {
            $vAlbum->cover = $vCover;
        }

        if ($request->filled('released')) {
            $vAlbum->released = $request->input('released');
        }

        $vAlbum->save();

        return response('Audio Album Edited', 200);
    }
}
