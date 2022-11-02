<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
                "ft" => $video->ft,
                "video_album_id" => $video->video_album_id,
                "album" => $video->albums->name,
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

        // Check if user is musician
        $accountCheck = User::where('username', auth()->user()->username)->first();

        if ($accountCheck->account_type == "normal") {
            $user = User::find($accountCheck->id);
            $user->account_type = "musician";
            $user->save();
        }

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
        if ($request->filled('album')) {
            $video->album = $request->input('album');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video, $id)
    {
        //
    }

    /**
     * Display a listing of the charts.
     *
     * @return \Illuminate\Http\Response
     */
    public function charts()
    {
        return $videoLikes = DB::table('video_likes')
            ->select('video_id', DB::raw('count(*) as likes'))
            ->groupBy('video_id')
            ->orderBy('likes', 'DESC')
            ->get();
    }
}
