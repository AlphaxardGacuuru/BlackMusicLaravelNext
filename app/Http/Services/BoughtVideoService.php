<?php

namespace App\Http\Services;

use App\Http\Resources\BoughtVideoResource;
use App\Models\BoughtAudio;
use App\Models\BoughtVideo;
use App\Models\CartVideo;
use App\Models\Deco;
use App\Models\Kopokopo;
use Illuminate\Support\Facades\DB;

class BoughtVideoService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getBoughtVideos = BoughtVideo::where("username", $this->username)->get();

        return BoughtVideoResource::collection($getBoughtVideos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user)
    {
        $canBuy = "";
        $structuredBoughtVideos = [];
        $boughtVideos = [];
        $decoArtists = [];

        /* Fetch songs from Cart Videos */
        $cartVideos = CartVideo::where('username', $user->username)
            ->get();

        foreach ($cartVideos as $cartVideo) {
            // Get Cost of Bought Videos and Audios
            $totalVideos = BoughtVideo::where('username', $user->username)
                ->count() * 20;
            $totalAudios = BoughtAudio::where('username', $user->username)
                ->count() * 10;

            // Get Total Cash paid
            $kopokopo = Kopokopo::where('username', $user->username);
            $kopokopoSum = $kopokopo->sum('amount');
            $balance = $kopokopoSum - ($totalVideos + $totalAudios);

            // Check if user can buy songs in cart
            $canBuy = intval($balance / 20);

            if ($canBuy >= 1) {
                $notBought = BoughtVideo::where('username', $user->username)
                    ->where('video_id', $cartVideo->video_id)
                    ->doesntExist();

                if ($notBought) {

                    // Transaction to make sure a video is bought and remove from cart and if user qualifies, a deco is saved
                    $artist = DB::transaction(function () use ($cartVideo, $user) {

                        $this->storeBoughtVideo($cartVideo, $user->username);

                        /* Add deco if necessary */
                        $artist = $this->storeDeco($cartVideo, $user->username);

                        /* Delete from cart */
                        CartVideo::where('video_id', $cartVideo->video_id)
                            ->where('username', $user->username)
                            ->delete();

                        return $artist;
                    });

                    // Update array for use in Event
                    array_push($boughtVideos, $cartVideo->video);
					// Array for showing receipt
                    array_push($structuredBoughtVideos, $cartVideo);

                    // Update Deco array
                    $artist && array_push($decoArtists, $artist);
                }
            }
        }

        $structuredBoughtVideos = BoughtVideoResource::collection($structuredBoughtVideos);

        return [$structuredBoughtVideos, $boughtVideos, $decoArtists];
    }

    // Store Bought Video
    private function storeBoughtVideo($cartVideo, $username)
    {
        /* Add song to videos_bought */
        $boughtVideo = new BoughtVideo;
        $boughtVideo->video_id = $cartVideo->video_id;
        $boughtVideo->price = 20;
        $boughtVideo->username = $username;
        $boughtVideo->artist = $cartVideo->video->username;
        $boughtVideo->save();
    }

    // Store Deco
    public function storeDeco($cartVideo, $username)
    {
        /* Check if songs are 10 */
        $userDecos = Deco::where('username', $username)
            ->where('artist', $cartVideo->video->username)
            ->count();

        $userVideos = BoughtVideo::where('username', $username)
            ->where('artist', $cartVideo->video->username)
            ->count();

        $decoBalance = ($userVideos / 10) - $userDecos;

        $canAddDeco = intval($decoBalance);

        /* If deco balance >= 1 then add deco */
        if ($canAddDeco >= 1) {
            $deco = new Deco;
            $deco->username = $username;
            $deco->artist = $cartVideo->video->username;
            $deco->save();

            return $cartVideo->video->username;
        }
    }

    /*
     * Artist's Bought Videos */
    public function artistBoughtVideos($username)
    {
        $getArtistBoughtVideos = BoughtVideo::where("artist", $username)->get();

        return BoughtVideoResource::collection($getArtistBoughtVideos);
    }
}
