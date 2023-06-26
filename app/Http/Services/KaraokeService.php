<?php

namespace App\Http\Services;

use App\Models\Karaoke;

class KaraokeService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Karaokes
        $getKaraokes = Karaoke::orderBy('id', 'ASC')->get();

        $karaokes = [];

        foreach ($getKaraokes as $key => $karaoke) {

            array_push($karaokes, [
                "id" => $karaoke->id,
                "karaoke" => $karaoke->karaoke,
                "audioId" => $karaoke->audio_id,
                "audioName" => $karaoke->audio->name,
                "audioThumbnail" => $karaoke->audio->thumbnail,
                "name" => $karaoke->user->name,
                "username" => $karaoke->user->username,
                "avatar" => $karaoke->user->avatar,
                "decos" => $karaoke->user->decos->count(),
                "description" => $karaoke->description,
                "hasLiked" => $karaoke->hasLiked($this->username),
                "hasSaved" => $karaoke->hasSaved($this->username),
                "likes" => $karaoke->likes->count(),
                "comments" => $karaoke->comments->count(),
                "created_at" => $karaoke->created_at,
            ]);
        }

        return $karaokes;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Karaoke::find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $karaoke = new Karaoke;
        $karaoke->karaoke = $request->input("karaoke");
        $karaoke->username = auth("sanctum")->user()->username;
        $karaoke->audio_id = $request->input("audio_id");
        $karaoke->description = $request->input("description");
        $karaoke->save();

        return response("Karaoke Created", 200);
    }
}
