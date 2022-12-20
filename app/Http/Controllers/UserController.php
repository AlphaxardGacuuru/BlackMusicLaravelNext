<?php

namespace App\Http\Controllers;

use App\Models\AudioAlbum;
use App\Models\BoughtAudio;
use App\Models\BoughtVideo;
use App\Models\Follow;
use App\Models\User;
use App\Models\VideoAlbum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getUsers = User::all();

        $users = [];

        // Check if user is logged in
        if (Auth::check()) {
            $authUsername = auth()->user()->username;
        } else {
            $authUsername = '@guest';
        }

        // Get Users
        foreach ($getUsers as $key => $user) {

            // Format profile pic
            $pp = preg_match("/http/", $user->pp) ? $user->pp : "/storage/" . $user->pp;

            // Check if user has followed User
            $hasFollowed = $user->follows
                ->where('username', $authUsername)
                ->count() > 1 ? true : false;

            // Get user's fans
            $fans = Follow::where('followed', $user->username)->count() - 1;

            // Check if auth user has bought user's video
            $hasBoughtVideo = BoughtVideo::where('username', $authUsername)
                ->where('artist', $user->username)
                ->count();

            // Check if auth user has bought user's audio
            $hasBoughtAudio = BoughtAudio::where('username', $authUsername)
                ->where('artist', $user->username)
                ->count();

            // Check if user has bought atleast 1 song
            $hasBought1 = ($hasBoughtVideo + $hasBoughtAudio) > 1 ? true : false;

            array_push($users, [
                "id" => $user->id,
                "name" => $user->name,
                "username" => $user->username,
                "pp" => $pp,
                "account_type" => $user->account_type,
                "bio" => $user->bio,
                "withdrawal" => $user->withdrawal,
                "posts" => $user->posts->count(),
                "following" => $user->follows->count() - 1,
                "fans" => $fans,
                "hasFollowed" => $hasFollowed,
                "hasBought1" => $hasBought1,
                "decos" => $user->decos->count(),
                "updated_at" => $user->updated_at->format("d M Y"),
                "created_at" => $user->created_at->format("d M Y"),
            ]);
        }

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string|nullable|max:20',
            'phone' => 'string|nullable|startsWith:0|min:10|max:10',
            'filepond-profile-pic' => 'nullable|max:9999',
            'bio' => 'string|nullable|max:50',
            'withdrawal' => 'string|nullable',
        ]);

        /* Update profile */
        $user = User::find($id);

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        if ($request->filled('phone')) {
            $user->phone = $request->input('phone');
            $user->password = Hash::make($request->input('phone'));
        }

        if ($request->filled('account_type') && $user->account_type == "normal") {

            $user->account_type = $request->input('account_type');

            /* Create new video album */
            $vAlbum = new VideoAlbum;
            $vAlbum->name = "Singles";
            $vAlbum->username = auth()->user()->username;
            $vAlbum->cover = "video-album-covers/musical-note.png";
            $vAlbum->released = Carbon::now();
            $vAlbum->save();

            /* Create new audio album */
            $aAlbum = new AudioAlbum;
            $aAlbum->name = "Singles";
            $aAlbum->username = auth()->user()->username;
            $aAlbum->cover = "audio-album-covers/musical-note.png";
            $vAlbum->released = Carbon::now();
            $aAlbum->save();
        }

        if ($request->filled('bio')) {
            $user->bio = $request->input('bio');
        }

        if ($request->filled('withdrawal')) {
            $user->withdrawal = $request->input('withdrawal');
        }

        $user->save();

        return response("Account updated", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function auth()
    {

        // Check if user is logged in
        if (Auth::check()) {

            $auth = Auth::user();

            // Get Cost of Bought Videos at each price
            $totalVideos = $auth->boughtVideos->count() * 20;
            $totalAudios = $auth->boughtAudios->count() * 10;

            // Get Total Cash paid
            $kopokopo = $auth->kopokopos->sum('amount');
            $balance = $kopokopo - ($totalVideos + $totalAudios);

            // Format profile pic
            $pp = preg_match("/http/", $auth->pp) ?
            $auth->pp : "/storage/" . $auth->pp;

            return [
                "id" => $auth->id,
                "name" => $auth->name,
                "username" => $auth->username,
                "email" => $auth->email,
                "phone" => $auth->phone,
                "account_type" => $auth->account_type,
                "pp" => $pp,
                "pb" => $auth->pb,
                "bio" => $auth->bio,
                "dob" => $auth->dob,
                "withdrawal" => $auth->withdrawal,
                "decos" => $auth->decos->count(),
                "fans" => Follow::where('followed', $auth->username)->count() - 1,
                "following" => $auth->follows->count(),
                "posts" => $auth->posts->count(),
                "balance" => $balance,
                "created_at" => $auth->created_at,
            ];
        }
    }
}
