<?php

namespace App\Services;

use App\Models\SavedKaraoke;

class SavedKaraokeService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get saved Karaokes
        $getSavedKarokes = SavedKaraoke::where('username', $this->username)
            ->orderBy('id', 'ASC')
            ->get();

        $savedKaraokes = [];

        foreach ($getSavedKarokes as $savedKaraoke) {

            array_push($savedKaraokes, [
                "id" => $savedKaraoke->karaoke->id,
                "karaoke" => $savedKaraoke->karaoke->karaoke,
                "audioId" => $savedKaraoke->karaoke->audio_id,
                "audioName" => $savedKaraoke->karaoke->audio->name,
                "audioThumbnail" => $savedKaraoke->karaoke->audio->thumbnail,
                "name" => $savedKaraoke->karaoke->user->name,
                "username" => $savedKaraoke->karaoke->user->username,
                "avatar" => $savedKaraoke->karaoke->user->avatar,
                "decos" => $savedKaraoke->karaoke->user->decos->count(),
                "description" => $savedKaraoke->karaoke->description,
                "hasLiked" => $savedKaraoke->karaoke->hasLiked($this->username),
                "hasSaved" => $savedKaraoke->karaoke->hasSaved($this->username),
                "likes" => $savedKaraoke->karaoke->likes->count(),
                "comments" => $savedKaraoke->karaoke->comments->count(),
                "createdAt" => $savedKaraoke->karaoke->created_at,
            ]);
        }

        return response($savedKaraokes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasSaved = SavedKaraoke::where('karaoke_id', $request->input('id'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasSaved) {
            SavedKaraoke::where('karaoke_id', $request->input('id'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Karaoke removed";
        } else {
            /* Create new karaoke song */
            $savedKaraoke = new SavedKaraoke;
            $savedKaraoke->karaoke_id = $request->input('id');
            $savedKaraoke->username = auth('sanctum')->user()->username;
            $savedKaraoke->save();

            $message = "Karaoke saved";
        }

        return response($message, 200);
    }
}