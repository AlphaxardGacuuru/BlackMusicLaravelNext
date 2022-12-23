<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Add follow */
        $hasFollowed = Follow::where('followed', $request->musician)
            ->where('username', auth()->user()->username)
            ->exists();

        if ($hasFollowed) {
            Follow::where('followed', $request->musician)
                ->where('username', auth()->user()->username)
                ->delete();

            $message = "Unfollowed";
        } else {
            $post = new Follow;
            $post->followed = $request->input('musician');
            $post->username = auth()->user()->username;
            $post->save();
			
            $message = "Followed";

            // Notify Musician
            // $musician = User::where('username', $request->input('musician'))
                // ->first();

            // $musician->notify(new FollowNotifications);
        }

        return response('You ' . $message . ' ' . $request->musician, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        //
    }
}
