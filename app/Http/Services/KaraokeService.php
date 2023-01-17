<?php

namespace App\Http\Services;

use App\Models\Karaoke;
use App\Models\SavedKaraoke;

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
                "audio_id" => $karaoke->audio_id,
                "audio_name" => $karaoke->audio->name,
                "audio_thumbnail" => $karaoke->audio->thumbnail,
                "name" => $karaoke->user->name,
                "username" => $karaoke->user->username,
                "avatar" => $karaoke->user->avatar(),
                "decos" => $karaoke->user->decos->count(),
                "description" => $karaoke->description,
                "hasLiked" => $karaoke->hasLiked($karaoke, $authUsername),
                "hasSaved" => $karaoke->hasSaved($karaoke, $authUsername),
                "likes" => $karaoke->likes->count(),
                "comments" => $karaoke->comments->count(),
                "created_at" => $karaoke->created_at->format('d M Y'),
            ]);
        }

        return $karaokes;
    }
}
