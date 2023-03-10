<?php

namespace App\Http\Services;

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
        /* Add follow */
        $hasFollowed = Follow::where('followed', $request->musician)
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasFollowed) {
            Follow::where('followed', $request->musician)
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Unfollowed";
			$added = false;
        } else {
            $post = new Follow;
            $post->followed = $request->input('musician');
            $post->username = auth('sanctum')->user()->username;
            $post->save();

            $message = "Followed";
			$added = true;
        }

        return [$added, $message];
    }
}
