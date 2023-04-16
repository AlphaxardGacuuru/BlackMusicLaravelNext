<?php

namespace App\Http\Controllers;

use App\Events\AudioBoughtEvent;
use App\Models\BoughtAudio;
use App\Services\BoughtAudioService;
use Illuminate\Http\Request;

class BoughtAudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BoughtAudioService $service)
    {
        return $service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BoughtAudioService $service)
    {
        $response = $service->store($request);

        $hasBought = count($response[0]) > 0;

        AudioBoughtEvent::dispatchIf($hasBought, $response[0], $response[1]);

        return response($response[0], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BoughtAudio  $boughtAudio
     * @return \Illuminate\Http\Response
     */
    public function show(BoughtAudio $boughtAudio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BoughtAudio  $boughtAudio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoughtAudio $boughtAudio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BoughtAudio  $boughtAudio
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoughtAudio $boughtAudio)
    {
        //
    }

	/*
	* Artist's Bought Audios */
	public function artistBoughtAudios($username, BoughtAudioService $service)
	{
		return $service->artistBoughtAudios($username);
	} 
}
