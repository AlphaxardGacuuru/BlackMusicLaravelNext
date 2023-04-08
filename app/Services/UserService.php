<?php

namespace App\Services;

use App\Models\AudioAlbum;
use App\Models\User;
use App\Models\VideoAlbum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
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

        // Get Users
        foreach ($getUsers as $user) {

            array_push($users, $this->structure($user));
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

            DB::transaction(function () {

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

            });
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

        return $this->structure($auth);
    }

    public function structure($user)
    {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "username" => $user->username,
            "email" => $user->email,
            "phone" => $user->phone,
            "avatar" => $user->avatar,
            "backdrop" => $user->backdrop,
            "account_type" => $user->account_type,
            "dob" => $user->dob,
            "bio" => $user->bio,
            "withdrawal" => $user->withdrawal,
            "posts" => $user->posts->count(),
            "following" => $user->follows->count() - 1,
            "fans" => $user->fans(),
            "hasFollowed" => $user->hasFollowed($this->username),
            "hasBought1" => $user->hasBought1($this->username),
            "decos" => $user->decos->count(),
            "balance" => $user->balance(),
            "created_at" => $user->created_at,
        ];
    }
}
