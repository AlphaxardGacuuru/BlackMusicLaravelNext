<?php

namespace App\Services;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VideoService extends Service
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        // Get Videos
        $getVideos = Video::orderBy('id', 'ASC')->get();

        $videos = [];

        foreach ($getVideos as $video) {
            array_push($videos, $this->structure($video));
        }

        return $videos;
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        // Get Video
        $getVideo = Video::whereId($id)->get()[0];

        $video = [];

        array_push($video, $this->structure($getVideo));

        return $video;
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store($request)
    {
        /* Create new video song */
        $video = new Video;
        $video->video = $request->input('video');
        $video->name = $request->input('name');
        $video->username = auth("sanctum")->user()->username;
        $video->ft = $request->input('ft');
        $video->video_album_id = $request->input('video_album_id');
        $video->genre = $request->input('genre');
        $video->thumbnail = $request->input('thumbnail');
        $video->description = $request->input('description');
        $video->released = $request->input('released');
        $saved = $video->save();

        return ["saved" => $saved, "video" => $video];
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update($request, $id)
    {
        $video = Video::find($id);

        if ($request->filled('name')) {
            $video->name = $request->input('name');
        }

        if ($request->filled('ft')) {
            $video->ft = $request->input('ft');
        }

        if ($request->filled('video_album_id')) {
            $video->video_album_id = $request->input('video_album_id');
        }

        if ($request->filled('genre')) {
            $video->genre = $request->input('genre');
        }

        if ($request->filled('description')) {
            $video->description = $request->input('description');
        }

        if ($request->filled('released')) {
            $video->released = $request->input('released');
        }

        if ($request->filled('thumbnail')) {
            $video->thumbnail = $request->input('thumbnail');

            // Delete thumbnail
            $oldThumbnail = Video::find($id)->thumbnail;
            Storage::delete('public/' . $oldThumbnail);
        }

        if ($request->filled('video')) {
            $video->video = $request->input('video');

            // Delete video
            $oldVideo = Video::find($id)->video;
            Storage::delete('public/' . $oldVideo);
        }

        $video->save();

        return response('Video Edited', 200);
    }

    /**
     * Download Video.
     *
     */
    public function download($video, $id)
    {
        $video = Video::find($id);
        // Get file extesion
        $ext = substr($video->video, -3);

        $src = 'storage/' . $video->video;

        $name = $video->name . '.' . $ext;

        return response()->download($src, $name);
    }

    /**
     * Newly Released Chart
     *
     */
    public function newlyReleased()
    {
        // Get Videos
        $newlyReleased = Video::orderBy("id", "desc")->get();

        return response($this->chart($newlyReleased), 200);
    }

    /**
     * Trending Chart
     *
     */
    public function trending()
    {
        $trending = DB::table('bought_videos')
            ->select('video_id', DB::raw('count(*) as bought'))
            ->where("created_at", ">=", Carbon::now()->subWeek())
            ->groupBy('video_id')
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
        $topDownloaded = DB::table('bought_videos')
            ->select('video_id', DB::raw('count(*) as bought'))
            ->groupBy('video_id')
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
        $topLiked = DB::table('video_likes')
            ->select('video_id', DB::raw('count(*) as likes'))
            ->groupBy('video_id')
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
        $videoModel = $list;

        // Check if items should be fetched
        if ($loop) {
            $videoModel = [];

            foreach ($list as $item) {
                $video = Video::find($item->video_id);

                array_push($videoModel, $video);
            }
        }

        $videos = [];

        $chartArtists = [];

        // Populate Videos and Artists array
        foreach ($videoModel as $video) {
            array_push($videos, $this->structure($video));
            array_push($chartArtists, $video->username);
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

            array_push($artists, $userService->structure($getArtist));
        }

        return ["artists" => $artists, "videos" => $videos];
    }

    /*
     * Artist's Videos */
    public function artistVideos($username)
    {
        $getArtistVideos = Video::where("username", $username)->get();

        $artistVideos = [];

        foreach ($getArtistVideos as $video) {
            array_push($artistVideos, $this->structure($video));
        }

        return $artistVideos;
    }

    /**
     * Structure Video
     *
     */
    private function structure($video)
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
            "hasLiked" => $video->hasLiked($this->username),
            "likes" => $video->likes->count(),
            "comments" => $video->comments->count(),
            "inCart" => $video->inCart($this->username),
            "hasBoughtVideo" => $video->hasBoughtVideo($this->username),
            "hasBought1" => $video->user->hasBought1($this->username),
            "hasFollowed" => $video->user->hasFollowed($this->username),
            "downloads" => $video->bought->count(),
            "createdAt" => $video->created_at,
        ];
    }
}