<?php

namespace App\Http\Services;

use App\Models\Audio;
use Carbon\Carbon;
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
                "avatar" => $audio->avatar($audio),
                "ft" => $audio->ft,
                "audio_album_id" => $audio->audio_album_id,
                "album" => $audio->album->name,
                "genre" => $audio->genre,
                "thumbnail" => $audio->thumbnail($audio),
                "description" => $audio->description,
                "released" => $audio->released->format('d M Y'),
                "hasLiked" => $audio->hasLiked($audio, $authUsername),
                "likes" => $audio->likes->count(),
                "comments" => $audio->comments->count(),
                "inCart" => $audio->inCart($audio, $authUsername),
                "hasBoughtAudio" => $audio->hasBoughtAudio($audio, $authUsername),
                "downloads" => $audio->bought->count(),
                "created_at" => $audio->created_at->format('d M Y'),
            ]);
        }

        return $audios;
    }

    public function show($audio, $id)
    {
        $audio = Audio::find($id);
        // Get file extesion
        $ext = substr($audio->audio, -3);

        $src = 'storage/' . $audio->audio;

        $name = $audio->name . '.' . $ext;

        return response()->download($src, $name);
    }

    public function store($request)
    {
        /* Create new audio song */
        $audio = new Audio;
        $audio->audio = $request->input('audio');
        $audio->name = $request->input('name');
        $audio->username = $request->input('username');
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
}
