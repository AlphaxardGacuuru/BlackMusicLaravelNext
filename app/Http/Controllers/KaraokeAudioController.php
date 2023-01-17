<?php

namespace App\Http\Controllers;

use App\Http\Services\KaraokeAudioService;
use App\Models\KaraokeAudio;
use Illuminate\Http\Request;

class KaraokeAudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KaraokeAudioService $karaokeAudioService)
    {
        return $karaokeAudioService->index();
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
     * @param  \App\Models\KaraokeAudio  $karaokeAudio
     * @return \Illuminate\Http\Response
     */
    public function show($id, KaraokeAudioService $karaokeAudioService)
    {
        return $karaokeAudioService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaraokeAudio  $karaokeAudio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaraokeAudio $karaokeAudio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaraokeAudio  $karaokeAudio
     * @return \Illuminate\Http\Response
     */
    public function destroy(KaraokeAudio $karaokeAudio)
    {
        //
    }
}
