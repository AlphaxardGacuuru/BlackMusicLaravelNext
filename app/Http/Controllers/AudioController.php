<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Services\AudioService;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AudioService $service)
    {
        return $service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AudioService $service)
    {
        // Handle form for audio
        $this->validate($request, [
            'audio' => 'required|string',
            'name' => 'required|string',
            'thumbnail' => 'required',
            'ft' => 'nullable|exists:users,username',
        ]);

        return $service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function show($id, AudioService $service)
    {
        return $service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, AudioService $service)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'ft' => 'nullable|exists:users,username',
        ]);

        return $service->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audio $audio, $id)
    {
        //
    }

    /*
     * Display a listing of the charts.
     *
     */
    public function newlyReleased(AudioService $service)
    {
        return $service->newlyReleased();
    }

    public function trending(AudioService $service)
    {
        return $service->trending();
    }

    public function topDownloaded(AudioService $service)
    {
		return $service->topDownloaded();
    }

    public function topLiked(AudioService $service)
    {
		return $service->topLiked();
    }

	/*
	* Artist's Audios */
	public function artistAudios($username, AudioService $service)
	{
		return $service->artistAudios($username);
	} 
}
