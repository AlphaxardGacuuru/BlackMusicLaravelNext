<?php

namespace App\Services;

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
                "cartId" => $cartAudio->id,
                "id" => $cartAudio->audio_id,
                "audio" => $cartAudio->audio->audio,
                "name" => $cartAudio->audio->name,
                "artistName" => $cartAudio->audio->user->name,
                "username" => $cartAudio->audio->username,
                "avatar" => $cartAudio->audio->user->avatar,
                "artistDecos" => $cartAudio->audio->user->decos->count(),
                "ft" => $cartAudio->audio->ft,
                "audioAlbumId" => $cartAudio->audio->audio_album_id,
                "album" => $cartAudio->audio->album->name,
                "genre" => $cartAudio->audio->genre,
                "thumbnail" => $cartAudio->audio->thumbnail,
                "description" => $cartAudio->audio->description,
                "released" => $cartAudio->audio->released,
                "hasLiked" => $cartAudio->audio->hasLiked($authUsername),
                "likes" => $cartAudio->audio->likes->count(),
                "comments" => $cartAudio->audio->comments->count(),
                "inCart" => $cartAudio->audio->inCart($authUsername),
                "hasBoughtAudio" => $cartAudio->audio->hasBoughtAudio($authUsername),
                "hasBought1" => $cartAudio->audio->user->hasBought1($authUsername),
                "hasFollowed" => $cartAudio->audio->user->hasFollowed($authUsername),
                "downloads" => $cartAudio->audio->bought->count(),
                "createdAt" => $cartAudio->audio->created_at,
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
