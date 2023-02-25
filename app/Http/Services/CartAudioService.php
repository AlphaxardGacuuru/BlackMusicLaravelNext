<?php

namespace App\Http\Services;

use App\Models\CartAudio;

class CartAudioService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        $getCartAudios = CartAudio::where('username', $authUsername)
            ->get();

        $cartAudios = [];

        foreach ($getCartAudios as $cartAudio) {
            array_push($cartAudios, [
                "id" => $cartAudio->id,
                "audioId" => $cartAudio->audio_id,
                "name" => $cartAudio->audio->name,
                "artist" => $cartAudio->audio->username,
                "ft" => $cartAudio->audio->ft,
                "thumbnail" => $cartAudio->audio->thumbnail,
                "username" => $cartAudio->username,
            ]);
        }

        return $cartAudios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        /* Check if item is already in cart */
        $inCart = CartAudio::where('audio_id', $request->input('audio'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        /* Insert or Remove from cart */
        if ($inCart) {
            CartAudio::where('audio_id', $request->input('audio'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = 'Audio removed from Cart';
        } else {
            $cartAudio = new CartAudio;
            $cartAudio->audio_id = $request->input('audio');
            $cartAudio->username = auth('sanctum')->user()->username;
            $cartAudio->save();

            $message = 'Audio added to Cart';
        }

        return response($message, 200);
    }
}
