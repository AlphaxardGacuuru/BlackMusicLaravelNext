<?php

namespace App\Http\Services;

use App\Models\Video;
use Carbon\Carbon;
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

            array_push($videos, [
                "id" => $video->id,
                "video" => $video->video,
                "name" => $video->name,
                "username" => $video->username,
                "avatar" => $video->avatar($video),
                "ft" => $video->ft,
                "video_album_id" => $video->video_album_id,
                "album" => $video->album->name,
                "genre" => $video->genre,
                "thumbnail" => $video->thumbnail($video),
                "description" => $video->description,
                "released" => $video->released->format('d M Y'),
                "hasLiked" => $video->hasLiked($video, $authUsername),
                "likes" => $video->likes->count(),
                "inCart" => $video->inCart($video, $authUsername),
                "hasBoughtVideo" => $video->hasBoughtVideo($video, $authUsername),
                "downloads" => $video->bought->count(),
                "created_at" => $video->created_at->format('d M Y'),
            ]);
        }

        return $videos;
    }

    public function show($video, $id)
    {
        $video = Video::find($id);
        // Get file extesion
        $ext = substr($video->video, -3);

        $src = 'storage/' . $video->video;

        $name = $video->name . '.' . $ext;

        return response()->download($src, $name);
    }

    public function store($request)
    {
        /* Create new video song */
        $video = new Video;
        $video->video = $request->input('video');
        $video->name = $request->input('name');
        $video->username = $request->input('username');
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
}
