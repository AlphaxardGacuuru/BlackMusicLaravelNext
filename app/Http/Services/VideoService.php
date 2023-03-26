<?php

namespace App\Http\Services;

use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        // Get Videos
        $getVideos = Video::orderBy('id', 'ASC')->get();

        $videos = [];

        foreach ($getVideos as $video) {

            array_push($videos, $this->structure($video, $authUsername));
        }

        return $videos;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Check if user is logged in
        $auth = auth("sanctum")->user();

        $authUsername = $auth ? $auth->username : "@guest";

        // Get Video
        $getVideo = Video::whereId($id)->get()[0];

        $video = [];

        array_push($video, $this->structure($getVideo, $authUsername));

        return $video;
    }

    public function store($request)
    {
        /* Create new video song */
        $video = new Video;
        $video->video = $request->input('video');
        $video->name = $request->input('name');
        $video->username = auth('sanctum')->user()->username;
        $video->ft = $request->input('ft');
        $video->video_album_id = $request->input('video_album_id');
        $video->genre = $request->input('genre');
        $video->thumbnail = $request->input('thumbnail');
        $video->description = $request->input('description');
        $video->released = $request->input('released');
        $video->save();

        return response('Video Uploaded', 200);
    }

    /* Create new video song */
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

    public function download($video, $id)
    {
        $video = Video::find($id);
        // Get file extesion
        $ext = substr($video->video, -3);

        $src = 'storage/' . $video->video;

        $name = $video->name . '.' . $ext;

        return response()->download($src, $name);
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
