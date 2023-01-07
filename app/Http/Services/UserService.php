<?php

namespace App\Http\Services;

use App\Models\AudioAlbum;
use App\Models\User;
use App\Models\VideoAlbum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();
        $authUsername = $auth ? $auth->username : '@guest';

        $getUsers = User::all();

        $users = [];

        // Get Users
        foreach ($getUsers as $user) {

            array_push($users, [
                "id" => $user->id,
                "name" => $user->name,
                "username" => $user->username,
                "avatar" => $user->avatar($user),
                "backdrop" => $user->backdrop($user),
                "account_type" => $user->account_type,
                "bio" => $user->bio,
                "withdrawal" => $user->withdrawal,
                "posts" => $user->posts->count(),
                "following" => $user->follows->count() - 1,
                "fans" => $user->fans($user),
                "hasFollowed" => $user->hasFollowed($user, $authUsername),
                "hasBought1" => $user->hasBought1($user, $authUsername),
                "decos" => $user->decos->count(),
                "updated_at" => $user->updated_at->format("d M Y"),
                "created_at" => $user->created_at->format("d M Y"),
            ]);
        }

        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
	public function show($id)
	{
		return User::find($id);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
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
            $vAlbum->username = auth('sanctum')->user()->username;
            $vAlbum->cover = "video-album-covers/musical-note.png";
            $vAlbum->released = Carbon::now();
            $vAlbum->save();

            /* Create new audio album */
            $aAlbum = new AudioAlbum;
            $aAlbum->name = "Singles";
            $aAlbum->username = auth('sanctum')->user()->username;
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
    public function auth()
    {
        $auth = auth('sanctum')->user();

        return [
            "id" => $auth->id,
            "name" => $auth->name,
            "username" => $auth->username,
            "email" => $auth->email,
            "phone" => $auth->phone,
            "account_type" => $auth->account_type,
            "avatar" => $auth->avatar($auth),
            "backdrop" => $auth->backdrop($auth),
            "bio" => $auth->bio,
            "dob" => $auth->dob,
            "withdrawal" => $auth->withdrawal,
            "decos" => $auth->decos->count(),
            "fans" => $auth->fans($auth),
            "following" => $auth->follows->count(),
            "posts" => $auth->posts->count(),
            "balance" => $auth->balance($auth),
            "created_at" => $auth->created_at,
        ];
    }
}
