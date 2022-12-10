<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AudioController extends Controller
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

        // Get Audios
        $getAudios = Audio::orderBy('id', 'ASC')->get();

        $audios = [];

        foreach ($getAudios as $key => $audio) {

            $thumbnail = preg_match("/http/", $audio->thumbnail) ?
            $audio->thumbnail :
            "/storage/" . $audio->thumbnail;

            // Check if user has liked audio
            $hasLiked = $audio->likes
                ->where('username', $authUsername)
                ->count() > 0 ? true : false;

            // Check if audio in cart
            $inCart = $audio->cart
                ->where('username', $authUsername)
                ->count() > 0 ? true : false;

            // Check if user has bought audio
            $hasBoughtAudio = $audio->bought
                ->where('username', $authUsername)
                ->count() > 0 ? true : false;

            array_push($audios, [
                "id" => $audio->id,
                "audio" => $audio->audio,
                "name" => $audio->name,
                "username" => $audio->username,
                "ft" => $audio->ft,
                "audio_album_id" => $audio->audio_album_id,
                "album" => $audio->album->name,
                "genre" => $audio->genre,
                "thumbnail" => $thumbnail,
                "description" => $audio->description,
                "released" => $audio->released,
                "hasLiked" => $hasLiked,
                "likes" => $audio->likes->count(),
                "inCart" => $inCart,
                "hasBoughtAudio" => $hasBoughtAudio,
                "downloads" => $audio->bought->count(),
                "created_at" => $audio->created_at->format('d M Y'),
            ]);
        }

        return $audios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'audio' => 'required',
            'name' => 'required|string',
            'thumbnail' => 'required',
            'ft' => 'nullable|exists:users,username',
        ]);

        // Format Released date
        $released = $request->input('released');
        $released = Carbon::parse($released)->format("d M Y");

        /* Create new audio song */
        $audio = new Audio;
        $audio->name = $request->input('name');
        $audio->username = auth()->user()->username;
        $audio->ft = $request->input('ft') ? $request->input('ft') : "";
        $audio->audio_album_id = $request->input('audio_album_id');
        $audio->genre = $request->input('genre');
        $audio->audio = $request->input('audio');
        $audio->thumbnail = $request->input('thumbnail');
        $audio->description = $request->input('description');
        $audio->released = $released;
        $audio->save();

        return response('Audio Uploaded', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $audio = Audio::find($id);
        // Get file extesion
        $ext = substr($audio->audio, -3);

        $src = 'storage/' . $audio->audio;

        $name = $audio->name . '.' . $ext;

        return response()->download($src, $name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('filepond')) {
            $request->file('filepond')->store('public/audios');
        } else {
            $this->validate($request, [
                'name' => 'nullable|string',
                'ft' => 'nullable|exists:users,username',
            ]);

            /* Handle thumbnail upload */
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail')->store('public/audio-thumbnails');
                $thumbnail = substr($thumbnail, 7);
                Storage::delete('public/' . Audio::where('id', $id)->first()->thumbnail);
            }

            $audio = Audio::find($id);

            if ($request->filled('name')) {
                $audio->name = $request->input('name');
            }

            if ($request->filled('ft')) {
                $audio->ft = $request->input('ft');
            }

            if ($request->filled('audio_album_id')) {
                $audio->album = $request->input('audio_album_id');
            }

            if ($request->filled('genre')) {
                $audio->genre = $request->input('genre');
            }

            if ($request->filled('description')) {
                $audio->description = $request->input('description');
            }

            if ($request->filled('released')) {
                // Format Released date
                $released = $request->input('released');
                $released = Carbon::parse($released)->format("d M Y");

                $audio->released = $released;
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

            return response("Audio Edited", 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audio $audio)
    {
        //
    }

    /*
     * Display a listing of the charts.
     *
     */
    public function charts()
    {
        return DB::table('audio_likes')
            ->select('audio_id', DB::raw('count(*) as likes'))
            ->groupBy('audio_id')
            ->orderBy('likes', 'DESC')
            ->get();
    }
}
