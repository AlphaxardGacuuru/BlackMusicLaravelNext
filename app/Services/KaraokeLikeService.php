<?php

namespace App\Services;

use App\Models\KaraokeLike;

class KaraokeLikeService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $hasLiked = KaraokeLike::where('karaoke_id', $request->input('karaoke'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        if ($hasLiked) {
            KaraokeLike::where('karaoke_id', $request->input('karaoke'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = "Like removed";
        } else {
            $karaokeLike = new KaraokeLike;
            $karaokeLike->karaoke_id = $request->input('karaoke');
            $karaokeLike->username = auth('sanctum')->user()->username;
            $karaokeLike->save();

            $message = "Karaoke liked";
        }

        return response($message, 200);
    }
}
