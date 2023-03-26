<?php

namespace App\Http\Services;

use App\Models\BoughtAudio;
use App\Models\BoughtVideo;
use App\Models\Follow;

class FollowService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        // Check if user has bought video or audio
        $hasBoughtVideo = BoughtVideo::where("username", auth("sanctum")->user()->username)
            ->where("artist", $request->input("musician"))
            ->exists();

        $hasBoughtAudio = BoughtAudio::where("username", auth("sanctum")->user()->username)
            ->where("artist", $request->input("musician"))
            ->exists();

        if ($hasBoughtVideo || $hasBoughtAudio) {
            // Check if user has followed
            $hasFollowed = Follow::where('followed', $request->musician)
                ->where('username', auth('sanctum')->user()->username)
                ->exists();

            if ($hasFollowed) {
                Follow::where('followed', $request->musician)
                    ->where('username', auth('sanctum')->user()->username)
                    ->delete();

                $message = 'You Unfollowed ' . $request->musician;
                $added = false;
            } else {
                $post = new Follow;
                $post->followed = $request->input('musician');
                $post->username = auth('sanctum')->user()->username;
                $post->save();

                $message = 'You Followed ' . $request->musician;
                $added = true;
            }

            return [$added, $message];
        }

        $message = "You must have bought atleast one song by " . $request->musician;

        return [false, $message];
    }
}
