<?php

namespace App\Http\Controllers;

use App\Models\AudioAlbum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Audio Albums
        $getAudioAlbums = AudioAlbum::all();

        $audioAlbums = [];

        foreach ($getAudioAlbums as $key => $audioAlbum) {
            array_push($audioAlbums, [
                "id" => $audioAlbum->id,
                "username" => $audioAlbum->username,
                "name" => $audioAlbum->name,
                "cover" => "/storage/" . $audioAlbum->cover,
                "released" => $audioAlbum->released,
                "created_at" => $audioAlbum->created_at->format("d M Y"),
            ]);
        }

        return $audioAlbums;
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
            $aCover = $request->file('cover')->store('public/audio-album-covers');
            $aCover = substr($aCover, 7);
        }

        // Format Released date
        $released = $request->input('released');
        $released = Carbon::parse($released);

        /* Create new video album */
        $aAlbum = new AudioAlbum;
        $aAlbum->name = $request->input('name');
        $aAlbum->username = auth()->user()->username;
        $aAlbum->cover = $aCover;
        $aAlbum->released = $released;
        $aAlbum->save();

        return response('Audio Album Created', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show(AudioAlbum $audioAlbum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cover' => 'nullable|image|max:1999',
        ]);

        /* Handle file upload */
        if ($request->hasFile('cover')) {
            $aCover = $request->file('cover')->store('public/audio-album-covers');
            $aCover = substr($aCover, 7);
            Storage::delete('public/' . AudioAlbum::where('id', $id)->first()->cover);
        }

        /* Create new video album */
        $aAlbum = AudioAlbum::find($id);

        if ($request->filled('name')) {
            $aAlbum->name = $request->input('name');
        }

        if ($request->hasFile('cover')) {
            $aAlbum->cover = $aCover;
        }

        if ($request->filled('released')) {
			// Format Released date
            $released = $request->input('released');
            $released = Carbon::parse($released);

            $aAlbum->released = $released;
        }

        $aAlbum->save();

        return response("Audio Album Edited", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function destroy(AudioAlbum $audioAlbum)
    {
        //
    }
}
