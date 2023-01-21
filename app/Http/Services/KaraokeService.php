<?php

namespace App\Http\Services;

use App\Models\Karaoke;

class KaraokeService
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();
        $authUsername = $auth ? $auth->username : '@guest';

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
                "hasLiked" => $karaoke->hasLiked($authUsername),
                "hasSaved" => $karaoke->hasSaved($authUsername),
                "likes" => $karaoke->likes->count(),
                "comments" => $karaoke->comments->count(),
                "created_at" => $karaoke->created_at,
            ]);
        }

        return $karaokes;
    }
}
