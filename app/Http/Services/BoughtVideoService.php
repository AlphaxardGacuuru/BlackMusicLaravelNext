<?php

namespace App\Http\Services;

use App\Models\BoughtAudio;
use App\Models\BoughtVideo;
use App\Models\CartVideo;
use App\Models\Deco;
use App\Models\Kopokopo;

class BoughtVideoService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getBoughtVideos = BoughtVideo::all();

        $boughtVideos = [];

        foreach ($getBoughtVideos as $boughtVideo) {
            array_push($boughtVideos, $this->structure($boughtVideo, auth('sanctum')->user()->username));
        }

        return $boughtVideos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $permission = "";
        $approved = [];
        /* Fetch songs from Cart Videos */
        $cartVideos = CartVideo::where('username', auth('sanctum')->user()->username)
            ->get();

        foreach ($cartVideos as $cartVideo) {
            // Get Cost of Bought Videos
            $totalVideos = BoughtVideo::where('username', auth('sanctum')->user()->username)->count() * 20;
            $totalAudios = BoughtAudio::where('username', auth('sanctum')->user()->username)->count() * 10;
            $betterPhone = substr_replace(auth('sanctum')->user()->phone, '+254', 0, -9);

            // Get Total Cash paid
            $kopokopo = Kopokopo::where('sender_phone_number', $betterPhone);
			$kopokopoSum = $kopokopo->sum('amount');
            $balance = $kopokopoSum - ($totalVideos + $totalAudios);

			// Get reference
			$reference = $kopokopo->first()->reference;

            // Check if user can buy songs in cart
            $permission = intval($balance / 20);

            if ($permission >= 1) {
                $bvQuery = BoughtVideo::where('username', auth('sanctum')->user()->username)
                    ->where('video_id', $cartVideo->video_id)
                    ->count();
                if ($bvQuery == 0) {
                    /* Add song to videos_bought */
                    $boughtVideos = new BoughtVideo;
                    $boughtVideos->video_id = $cartVideo->video_id;
                    $boughtVideos->reference = $reference;
                    $boughtVideos->price = 20;
                    $boughtVideos->username = auth('sanctum')->user()->username;
                    $boughtVideos->name = $cartVideo->video->name;
                    $boughtVideos->artist = $cartVideo->video->username;
                    $boughtVideos->save();

                    /* Showing video song bought notification */
                    $user = User::where('username', $cartVideo->video->username)
                        ->first();

                    $user->notify(new BoughtVideoNotifications($cartVideo));

                    /* Add deco if necessary */
                    /* Check if songs are 10 */
                    $userDecos = Deco::where('username', auth('sanctum')->user()->username)
                        ->where('artist', $cartVideo->video->username)
                        ->count();
                    $userVideos = BoughtVideo::where('username', auth('sanctum')->user()->username)
                        ->where('artist', $cartVideo->video->username)
                        ->count();
                    $userVideos = $userVideos / 10;
                    $decoBalance = $userVideos - $userDecos;
                    $decoPermission = intval($decoBalance);

                    /* If deco balance >= 1 then add deco */
                    if ($decoPermission >= 1) {
                        $deco = new Deco;
                        $deco->username = auth('sanctum')->user()->username;
                        $deco->artist = $cartVideo->video->username;
                        $deco->save();

                        /* Add deco notification */
                        auth('sanctum')->user()->notify(new DecoNotifications($cartVideo->video->username));
                    }
                    /* Delete from cart */
                    CartVideos::where('video_id', $cartVideo->video_id)
                        ->where('username', auth('sanctum')->user()->username)
                        ->delete();

                    // Update array
                    array_push($approved, $cartVideo->video->id);
                }
            }
        }

        $receiptVideos = [];

        foreach ($approved as $id) {

            $video = Video::find($id);

            array_push($receiptVideos, [
                "id" => $video->id,
                "video" => $video->video,
                "name" => $video->name,
                "username" => $video->username,
                "ft" => $video->ft,
                "album" => $video->album,
                "genre" => $video->genre,
                "thumbnail" => $video->thumbnail,
            ]);
        }

        // Notify User
        if (count($receiptVideos) > 0) {
            auth('sanctum')->user()->notify(new VideoReceiptNotifications($receiptVideos));
        }

        return response($receiptVideos, 200);
    }

    private function structure($video, $username)
    {
        return [
            "id" => $video->id,
            "video" => $video->video,
            "name" => $video->name,
            "artistName" => $video->user->name,
            "username" => $video->username,
            "avatar" => $video->user->avatar,
            "artistDecos" => $video->user->decos->count(),
            "ft" => $video->ft,
            "videoAlbumId" => $video->video_album_id,
            "album" => $video->album->name,
            "genre" => $video->genre,
            "thumbnail" => $video->thumbnail,
            "description" => $video->description,
            "released" => $video->released,
            "hasLiked" => $video->hasLiked($username),
            "likes" => $video->likes->count(),
            "comments" => $video->comments->count(),
            "inCart" => $video->inCart($username),
            "hasBoughtVideo" => $video->hasBoughtVideo($username),
            "hasBought1" => $video->user->hasBought1($username),
            "hasFollowed" => $video->user->hasFollowed($username),
            "downloads" => $video->bought->count(),
            "createdAt" => $video->created_at,
        ];
    }
}
