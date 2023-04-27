<?php

namespace App\Services;

use App\Models\BoughtAudio;
use App\Models\BoughtVideo;
use App\Models\CartAudio;
use App\Models\Deco;
use App\Models\Kopokopo;
use Illuminate\Support\Facades\DB;

class BoughtAudioService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getBoughtAudios = BoughtAudio::where("username", $this->username)->get();

        $boughtAudios = [];

        foreach ($getBoughtAudios as $boughtAudio) {
            array_push($boughtAudios,
                $this->structure($boughtAudio->audio));
        }

        return $boughtAudios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $canBuy = "";
        $boughtAudios = [];
        $decoArtists = [];

        /* Fetch songs from Cart Audios */
        $cartAudios = CartAudio::where('username', auth('sanctum')->user()->username)->get();

        foreach ($cartAudios as $cartAudio) {
            // Get Cost of Bought Videos and Audios
            $totalVideos = BoughtVideo::where('username', auth('sanctum')->user()->username)
                ->count() * 20;
            $totalAudios = BoughtAudio::where('username', auth('sanctum')->user()->username)
                ->count() * 10;

            // Get Total Cash paid
            $kopokopo = Kopokopo::where('username', auth('sanctum')->user()->username);
            $kopokopoSum = $kopokopo->sum('amount');
            $balance = $kopokopoSum - ($totalVideos + $totalAudios);

            // Check if user can buy songs in cart
            $canBuy = intval($balance / 20);

            if ($canBuy >= 1) {
                $notBought = BoughtAudio::where('username', auth('sanctum')->user()->username)
                    ->where('audio_id', $cartAudio->audio_id)
                    ->doesntExist();

                if ($notBought) {

                    // Transaction to make sure a video is bought and remove from cart and if user qualifies, a deco is saved
                    $artist = DB::transaction(function () use ($cartAudio) {

                        $this->storeBoughtAudio($cartAudio);

                        /* Add deco if necessary */
                        $artist = $this->storeDeco($cartAudio);

                        /* Delete from cart */
                        CartAudio::where('audio_id', $cartAudio->audio_id)
                            ->where('username', auth('sanctum')->user()->username)
                            ->delete();

                        return $artist;
                    });

                    // Update array
                    array_push($boughtAudios, $cartAudio->audio);
                    $artist && array_push($decoArtists, $artist);
                }
            }
        }

        return [$boughtAudios, $decoArtists];
    }

    // Store Bought Audio
    private function storeBoughtAudio($cartAudio)
    {
        /* Add song to audios_bought */
        $boughtAudio = new BoughtAudio;
        $boughtAudio->audio_id = $cartAudio->audio_id;
        $boughtAudio->price = 20;
        $boughtAudio->username = auth('sanctum')->user()->username;
        $boughtAudio->name = $cartAudio->audio->name;
        $boughtAudio->artist = $cartAudio->audio->username;
        $boughtAudio->save();
    }

    // Store Deco
    public function storeDeco($cartAudio)
    {
        /* Check if songs are 10 */
        $userDecos = Deco::where('username', auth('sanctum')->user()->username)
            ->where('artist', $cartAudio->audio->username)
            ->count();

        $userAudios = BoughtAudio::where('username', auth('sanctum')->user()->username)
            ->where('artist', $cartAudio->audio->username)
            ->count();

        $decoBalance = ($userAudios / 10) - $userDecos;

        $canAddDeco = intval($decoBalance);

        /* If deco balance >= 1 then add deco */
        if ($canAddDeco >= 1) {
            $deco = new Deco;
            $deco->username = auth('sanctum')->user()->username;
            $deco->artist = $cartAudio->audio->username;
            $deco->save();

            return $cartAudio->audio->username;
        }
    }

	/*
	* Artist's Bought Audios */
	public function artistBoughtAudios($username)
	{
		$getArtistBoughtAudios = BoughtAudio::where("artist", $username)->get();

		$artistBoughtAudios = [];

		foreach ($getArtistBoughtAudios as $boughtAudio) {
		array_push($artistBoughtAudios, $this->structure($boughtAudio->audio));
		}

		return $artistBoughtAudios;
	} 

    private function structure($audio)
    {
        return [
            "id" => $audio->id,
            "audio" => $audio->audio,
            "name" => $audio->name,
            "artistName" => $audio->user->name,
            "username" => $audio->username,
            "avatar" => $audio->user->avatar,
            "artistDecos" => $audio->user->decos->count(),
            "ft" => $audio->ft,
            "audioAlbumId" => $audio->audio_album_id,
            "album" => $audio->album->name,
            "genre" => $audio->genre,
            "thumbnail" => $audio->thumbnail,
            "description" => $audio->description,
            "released" => $audio->released,
            "hasLiked" => $audio->hasLiked($this->username),
            "likes" => $audio->likes->count(),
            "comments" => $audio->comments->count(),
            "inCart" => $audio->inCart($this->username),
            "hasBoughtAudio" => $audio->hasBoughtAudio($this->username),
            "hasBought1" => $audio->user->hasBought1($this->username),
            "hasFollowed" => $audio->user->hasFollowed($this->username),
            "downloads" => $audio->bought->count(),
            "createdAt" => $audio->created_at,
        ];
    }
}