<?php

namespace App\Http\Services;

use App\Models\KaraokeAudio;

class KaraokeAudioService
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KaraokeAudio::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getKaraokeAudio = KaraokeAudio::find($id);

        $karaokeAudio = [];

        array_push($karaokeAudio, [
            "id" => $getKaraokeAudio->id,
            "audioId" => $getKaraokeAudio->audio_id,
            "username" => $getKaraokeAudio->username,
            "name" => $getKaraokeAudio->audio->name,
            "thumbnail" => $getKaraokeAudio->audio->thumbnail(),
            "createdAt" => $getKaraokeAudio->created_at->format('d M Y'),
        ]);

        return $karaokeAudio;
    }
}
