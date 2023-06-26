<?php

namespace App\Http\Services;

use App\Models\BoughtAudio;
use App\Models\CartAudio;

class CartAudioService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getCartAudios = CartAudio::where('username', $this->username)
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
                "hasLiked" => $cartAudio->audio->hasLiked($this->username),
                "likes" => $cartAudio->audio->likes->count(),
                "comments" => $cartAudio->audio->comments->count(),
                "inCart" => $cartAudio->audio->inCart($this->username),
                "hasBoughtAudio" => $cartAudio->audio->hasBoughtAudio($this->username),
                "hasBought1" => $cartAudio->audio->user->hasBought1($this->username),
                "hasFollowed" => $cartAudio->audio->user->hasFollowed($this->username),
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

        /* Check item in not already bought*/
        $notBought = BoughtAudio::where('username', auth('sanctum')->user()->username)
            ->where('audio_id', $request->input('audio'))
            ->doesntExist();

        /* Insert or Remove from cart */
        if ($inCart && $notBought) {
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
