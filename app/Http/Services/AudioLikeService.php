<?php

namespace App\Http\Services;

use App\Models\AudioLike;

class AudioLikeService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasLiked = AudioLike::where('audio_id', $request->input('audio'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            AudioLike::where('audio_id', $request->input('audio'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Like removed";
        } else {
            $audioLike = new AudioLike;
            $audioLike->audio_id = $request->input('audio');
            $audioLike->username = auth('sanctum')->user()->username;
            $audioLike->save();

            $message = "Audio liked";

            // Show notification
            // $audio = Audios::where('id', $request->input('audio'))->first();
            // $audio->users->username != auth()->user()->username &&
            // $audio->users->notify(new AudioLikeNotifications($audio->name));
        }

        return response($message, 200);
    }
}
