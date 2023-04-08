<?php

namespace App\Services;

use App\Models\Audio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AudioService extends Service
{
    public function index()
    {
        /**
         * Display a listing of the resource.
         *
         */
        $getAudios = Audio::orderBy('id', 'ASC')->get();

        $audios = [];

        foreach ($getAudios as $audio) {

            array_push($audios, $this->structure($audio));
        }

        return $audios;
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        // Get Audio
        $getAudio = Audio::whereId($id)->get()[0];

        $audio = [];

        array_push($audio, $this->structure($getAudio));

        return $audio;
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store($request)
    {
        /* Create new audio song */
        $audio = new Audio;
        $audio->audio = $request->input('audio');
        $audio->name = $request->input('name');
        $audio->username = auth('sanctum')->user()->username;
        $audio->ft = $request->input('ft');
        $audio->audio_album_id = $request->input('audio_album_id');
        $audio->genre = $request->input('genre');
        $audio->thumbnail = $request->input('thumbnail');
        $audio->description = $request->input('description');
        $audio->released = $request->input('released');
        $audio->save();

        return response('Audio Uploaded', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update($request, $id)
    {
        $audio = Audio::find($id);

        if ($request->filled('name')) {
            $audio->name = $request->input('name');
        }

        if ($request->filled('ft')) {
            $audio->ft = $request->input('ft');
        }

        if ($request->filled('audio_album_id')) {
            $audio->audio_album_id = $request->input('audio_album_id');
        }

        if ($request->filled('genre')) {
            $audio->genre = $request->input('genre');
        }

        if ($request->filled('description')) {
            $audio->description = $request->input('description');
        }

        if ($request->filled('released')) {
            $audio->released = $request->input('released');
        }

        if ($request->filled('thumbnail')) {
            $audio->thumbnail = $request->input('thumbnail');

            // Delete thumbnail
            $oldThumbnail = Audio::find($id)->thumbnail;
            Storage::delete('public/' . $oldThumbnail);
        }

        if ($request->filled('audio')) {
            $audio->audio = $request->input('audio');

            // Delete audio
            $oldAudio = Audio::find($id)->audio;
            Storage::delete('public/' . $oldAudio);
        }

        $audio->save();

        return response('Audio Edited', 200);
    }

    /**
     * Download Audio.
     *
     */
    public function download($id)
    {
        $audio = Audio::find($id);
        // Get file extesion
        $ext = substr($audio->audio, -3);

        $src = 'storage/' . $audio->audio;

        $name = $audio->name . '.' . $ext;

        return response()->download($src, $name);
    }

    /**
     * Newly Released Chart
     *
     */
    public function newlyReleased()
    {
        // Get Audios
        $newlyReleased = Audio::orderBy("id", "desc")->get();

        return response($this->chart($newlyReleased), 200);
    }

    /**
     * Trending Chart
     *
     */
    public function trending()
    {
        $trending = DB::table('bought_audios')
            ->select('audio_id', DB::raw('count(*) as bought'))
            ->where("created_at", ">=", Carbon::now()->subWeek())
            ->groupBy('audio_id')
            ->orderBy('bought', 'DESC')
            ->get();

        return response($this->chart($trending, true), 200);
    }

    /**
     * Top Downloaded
     *
     */
    public function topDownloaded()
    {
        $topDownloaded = DB::table('bought_audios')
            ->select('audio_id', DB::raw('count(*) as bought'))
            ->groupBy('audio_id')
            ->orderBy('bought', 'DESC')
            ->get();

        return response($this->chart($topDownloaded, true), 200);
    }

    /**
     * Top Liked
     *
     */
    public function topLiked()
    {
        $topLiked = DB::table('audio_likes')
            ->select('audio_id', DB::raw('count(*) as likes'))
            ->groupBy('audio_id')
            ->orderBy('likes', 'DESC')
            ->get();

        return response($this->chart($topLiked, true), 200);
    }

    /**
     * Structure charts
     *
     */
    public function chart($list, $loop = false)
    {
        $audioModel = $list;

        // Check if items should be fetched
        if ($loop) {
            $audioModel = [];

            foreach ($list as $item) {
                $audio = Audio::find($item->audio_id);

                array_push($audioModel, $audio);
            }
        }

        $audios = [];

        $chartArtists = [];

        // Populate Audios and Artists array
        foreach ($audioModel as $audio) {
            array_push($audios, $this->structure($audio, $this->username));
            array_push($chartArtists, $audio->username);
        }

        // Count occurrences of artists
        $chartArtists = array_count_values($chartArtists);

        // Sort artists based on most occurences
        arsort($chartArtists);

        // Get usernames only
        $chartArtists = array_keys($chartArtists);

        $artists = [];

        // Get Artists
        foreach ($chartArtists as $artist) {
            $getArtist = User::where("username", $artist)->first();

            $userService = new UserService;

            array_push($artists, $userService->structure($getArtist, $this->username));
        }

        return ["artists" => $artists, "audios" => $audios];
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
