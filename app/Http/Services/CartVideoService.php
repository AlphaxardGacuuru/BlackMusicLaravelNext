<?php

namespace App\Http\Services;

use App\Models\CartVideo;

class CartVideoService
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

        $getCartVideos = CartVideo::where('username', $authUsername)
            ->get();

        $cartVideos = [];

        foreach ($getCartVideos as $cartVideo) {
            array_push($cartVideos, [
                "id" => $cartVideo->id,
                "videoId" => $cartVideo->video_id,
                "name" => $cartVideo->video->name,
                "artist" => $cartVideo->video->username,
                "ft" => $cartVideo->video->ft,
                "thumbnail" => $cartVideo->video->thumbnail,
                "username" => $cartVideo->username,
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

        /* Insert or Remove from cart */
        if ($inCart) {
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