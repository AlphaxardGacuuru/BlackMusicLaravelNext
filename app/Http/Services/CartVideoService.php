<?php

namespace App\Http\Services;

use App\Models\BoughtVideo;
use App\Models\CartVideo;

class CartVideoService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getCartVideos = CartVideo::where('username', $this->username)
            ->get();

        $cartVideos = [];

        foreach ($getCartVideos as $cartVideo) {
            array_push($cartVideos, [
                "cartId" => $cartVideo->id,
                "id" => $cartVideo->video_id,
                "video" => $cartVideo->video->video,
                "name" => $cartVideo->video->name,
                "artistName" => $cartVideo->video->user->name,
                "username" => $cartVideo->video->username,
                "avatar" => $cartVideo->video->user->avatar,
                "artistDecos" => $cartVideo->video->user->decos->count(),
                "ft" => $cartVideo->video->ft,
                "videoAlbumId" => $cartVideo->video->video_album_id,
                "album" => $cartVideo->video->album->name,
                "genre" => $cartVideo->video->genre,
                "thumbnail" => $cartVideo->video->thumbnail,
                "description" => $cartVideo->video->description,
                "released" => $cartVideo->video->released,
                "hasLiked" => $cartVideo->video->hasLiked($this->username),
                "likes" => $cartVideo->video->likes->count(),
                "comments" => $cartVideo->video->comments->count(),
                "inCart" => $cartVideo->video->inCart($this->username),
                "hasBoughtVideo" => $cartVideo->video->hasBoughtVideo($this->username),
                "hasBought1" => $cartVideo->video->user->hasBought1($this->username),
                "hasFollowed" => $cartVideo->video->user->hasFollowed($this->username),
                "downloads" => $cartVideo->video->bought->count(),
                "createdAt" => $cartVideo->video->created_at,
            ]);
        }

        return $cartVideos;
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
        $inCart = CartVideo::where('video_id', $request->input('video'))
            ->where('username', auth('sanctum')->user()->username)
            ->exists();

        /* Check item in not already bought*/
        $notBought = BoughtVideo::where('username', auth('sanctum')->user()->username)
            ->where('video_id', $request->input('video'))
            ->doesntExist();

        /* Insert or Remove from cart */
        if ($inCart && $notBought) {
            CartVideo::where('video_id', $request->input('video'))
                ->where('username', auth('sanctum')->user()->username)
                ->delete();

            $message = 'Video removed from Cart';
        } else {
            $cartVideo = new CartVideo;
            $cartVideo->video_id = $request->input('video');
            $cartVideo->username = auth('sanctum')->user()->username;
            $cartVideo->save();

            $message = 'Video added to Cart';
        }

        return response($message, 200);
    }
}
