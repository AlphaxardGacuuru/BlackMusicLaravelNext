<?php

namespace App\Http\Controllers;

use App\Events\AudioLikedEvent;
use App\Models\Audio;
use App\Models\AudioLike;\AudioLikeService;
use Illuminate\Http\Request;

class AudioLikeController extends Controller
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
    public function store(Request $request, AudioLikeService $service)
    {
        $result = $service->store($request);

        $audio = Audio::find($request->input("audio"));

        AudioLikedEvent::dispatchIf($result[0], $audio);

        return response($result[1], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioLike  $audioLike
     * @return \Illuminate\Http\Response
     */
    public function show(AudioLike $audioLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioLike  $audioLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AudioLike $audioLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AudioLike  $audioLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(AudioLike $audioLike)
    {
        //
    }
}
