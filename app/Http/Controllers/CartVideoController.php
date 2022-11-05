<?php

namespace App\Http\Controllers;

use App\Models\CartVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        if (Auth::check()) {
            $authUsername = auth()->user()->username;
        } else {
            $authUsername = '@guest';
        }

        $getCartVideos = CartVideo::where('username', $authUsername)
            ->get();

        $cartVideos = [];

        foreach ($getCartVideos as $key => $cartVideo) {
            array_push($cartVideos, [
                "id" => $cartVideo->id,
                "video_id" => $cartVideo->video_id,
                "name" => $cartVideo->video->name,
                "artist" => $cartVideo->video->username,
                "ft" => $cartVideo->video->ft,
                "thumbnail" => preg_match("/http/", $cartVideo->video->thumbnail) ?
                $cartVideo->video->thumbnail :
                "/storage/" . $cartVideo->video->thumbnail,
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
    public function store(Request $request)
    {
        /* Check if item is already in cart */
        $vcartCheck = CartVideo::where('video_id', $request->input('video'))
            ->where('username', auth()->user()->username)
            ->count();

        /* Insert or Remove from cart */
        if ($vcartCheck == 0) {
            $cartVideos = new CartVideo;
            $cartVideos->video_id = $request->input('video');
            $cartVideos->username = auth()->user()->username;
            $cartVideos->save();

            $message = 'Video added to Cart';
        } else {
            CartVideo::where('video_id', $request->input('video'))
                ->where('username', auth()->user()->username)
                ->delete();

            $message = 'Video removed from Cart';
        }

        return response($message, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartVideo  $cartVideo
     * @return \Illuminate\Http\Response
     */
    public function show(CartVideo $cartVideo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartVideo  $cartVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartVideo $cartVideo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartVideo  $cartVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartVideo $cartVideo)
    {
        //
    }
}
