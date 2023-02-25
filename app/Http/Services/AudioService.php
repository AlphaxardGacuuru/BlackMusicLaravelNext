<?php

namespace App\Http\Services;

use App\Models\Audio;
use Illuminate\Support\Facades\Storage;

class AudioService
{
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        // Get Audios
        $getAudios = Audio::orderBy('id', 'ASC')->get();

        $audios = [];

        foreach ($getAudios as $audio) {

            array_push($audios, [
                "id" => $audio->id,
                "audio" => $audio->audio,
                "name" => $audio->name,
                "username" => $audio->username,
                "avatar" => $audio->user->avatar,
                "ft" => $audio->ft,
                "audioAlbumId" => $audio->audio_album_id,
                "album" => $audio->album->name,
                "genre" => $audio->genre,
                "thumbnail" => $audio->thumbnail,
                "description" => $audio->description,
                "released" => $audio->released->format('d M Y'),
                "hasLiked" => $audio->hasLiked($authUsername),
                "likes" => $audio->likes->count(),
                "comments" => $audio->comments->count(),
                "inCart" => $audio->inCart($authUsername),
                "hasBoughtAudio" => $audio->hasBoughtAudio($authUsername),
                "downloads" => $audio->bought->count(),
                "createdAt" => $audio->created_at,
            ]);
        }

        return $audios;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        // Get Audio
        $getAudio = Audio::whereId($id)->get()[0];

        $audio = [];

        array_push($audio, [
            "id" => $getAudio->id,
            "audio" => $getAudio->audio,
            "name" => $getAudio->name,
			"artistName" => $getAudio->user->name,
            "username" => $getAudio->username,
			"avatar" => $getAudio->user->avatar,
			"artistDecos" => $getAudio->user->decos->count(),
            "ft" => $getAudio->ft,
            "audioAlbumId" => $getAudio->audio_album_id,
            "album" => $getAudio->album->name,
            "genre" => $getAudio->genre,
            "thumbnail" => $getAudio->thumbnail,
            "description" => $getAudio->description,
            "released" => $getAudio->released,
            "hasLiked" => $getAudio->hasLiked($authUsername),
            "likes" => $getAudio->likes->count(),
            "comments" => $getAudio->comments->count(),
            "inCart" => $getAudio->inCart($authUsername),
            "hasBoughtAudio" => $getAudio->hasBoughtAudio($authUsername),
			"hasBought1" => $getAudio->user->hasBought1($authUsername),
			"hasFollowed" => $getAudio->user->hasFollowed($authUsername),
            "downloads" => $getAudio->bought->count(),
            "createdAt" => $getAudio->created_at,
        ]);

        return $audio;
    }

    public function store($request)
    {
        /* Create new audio song */
        $audio = new Audio;
        $audio->audio = $request->input('audio');
        $audio->name = $request->input('name');
        $audio->username = auth('sanctum')->user()->username;
        $audio->ft = $request->input('ft');
        $audio->audio_album_id = $request->input('audio_album_id');
        $audio->genre = $request->input('genre');
        $audio->thumbnail = $request->input('thumbnail');
        $audio->description = $request->input('description');
        $audio->released = $request->input('released');
        $audio->save();

        return response('Audio Uploaded', 200);
    }

    /* Create new audio song */
    public function update($request, $id)
    {
        $audio = Audio::find($id);

        if ($request->filled('name')) {
            $audio->name = $request->input('name');
        }

        if ($request->filled('ft')) {
            $audio->ft = $request->input('ft');
        }

        if ($request->filled('audio_album_id')) {
            $audio->audio_album_id = $request->input('audio_album_id');
        }

        if ($request->filled('genre')) {
            $audio->genre = $request->input('genre');
        }

        if ($request->filled('description')) {
            $audio->description = $request->input('description');
        }

        if ($request->filled('released')) {
            $audio->released = $request->input('released');
        }

        if ($request->filled('thumbnail')) {
            $audio->thumbnail = $request->input('thumbnail');

            // Delete thumbnail
            $oldThumbnail = Audio::find($id)->thumbnail;
            Storage::delete('public/' . $oldThumbnail);
        }

        if ($request->filled('audio')) {
            $audio->audio = $request->input('audio');

            // Delete audio
            $oldAudio = Audio::find($id)->audio;
            Storage::delete('public/' . $oldAudio);
        }

        $audio->save();

        return response('Audio Edited', 200);
    }

    // Download Audio
    public function download($id)
    {
        $audio = Audio::find($id);
        // Get file extesion
        $ext = substr($audio->audio, -3);

        $src = 'storage/' . $audio->audio;

        $name = $audio->name . '.' . $ext;

        return response()->download($src, $name);
    }
}
