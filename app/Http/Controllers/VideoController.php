<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
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

        // Get Videos
        $getVideos = Video::orderBy('id', 'ASC')->get();

        $videos = [];

        foreach ($getVideos as $key => $video) {

            $thumbnail = preg_match("/http/", $video->thumbnail) ?
            $video->thumbnail :
            "/storage/" . $video->thumbnail;

            // Check if user has liked video
            $hasLiked = $video->likes
                ->where('username', $authUsername)
                ->count() > 0 ? true : false;

            // Check if video in cart
            $inCart = $video->cart
                ->where('username', $authUsername)
                ->count() > 0 ? true : false;

            // Check if user has bought video
            $hasBoughtVideo = $video->bought
                ->where('username', $authUsername)
                ->count() > 0 ? true : false;

            array_push($videos, [
                "id" => $video->id,
                "video" => $video->video,
                "name" => $video->name,
                "username" => $video->username,
                "profilePic" => $video->user->profile_pic,
                "ft" => $video->ft,
                "video_album_id" => $video->video_album_id,
                "album" => $video->album->name,
                "genre" => $video->genre,
                "thumbnail" => $thumbnail,
                "description" => $video->description,
                "released" => $video->released,
                "hasLiked" => $hasLiked,
                "likes" => $video->likes->count(),
                "inCart" => $inCart,
                "hasBoughtVideo" => $hasBoughtVideo,
                "downloads" => $video->bought->count(),
                "created_at" => $video->created_at->format('d M Y'),
            ]);
        }

        return $videos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Handle form for video
        $this->validate($request, [
            'video' => 'required|string',
            'name' => 'required|string',
            'thumbnail' => 'required',
            'ft' => 'nullable|exists:users,username',
        ]);

        // Format Released date
        $released = $request->input('released');
        $released = Carbon::parse($released);

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
        $video->released = $released;
        $video->save();

        return response('Video Uploaded', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video, $id)
    {
        $video = Video::find($id);
        // Get file extesion
        $ext = substr($video->video, -3);

        $src = 'storage/' . $video->video;

        $name = $video->name . '.' . $ext;

        return response()->download($src, $name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'ft' => 'nullable|exists:users,username',
        ]);

        /* Create new video song */
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
            // Format Released date
            $released = $request->input('released');
            $released = Carbon::parse($released);

            $video->released = $released;
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video, $id)
    {
        //
    }

    /*
     * Display a listing of the charts.
     *
     */
    public function charts()
    {
        return DB::table('video_likes')
            ->select('video_id', DB::raw('count(*) as likes'))
            ->groupBy('video_id')
            ->orderBy('likes', 'DESC')
            ->get();
    }
}
