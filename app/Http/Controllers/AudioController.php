<?php

namespace App\Http\Controllers;

use App\Http\Services\AudioService;
use App\Models\Audio;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AudioService $audioService)
    {
        return $audioService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AudioService $audioService)
    {
        // Handle form for audio
        $this->validate($request, [
            'audio' => 'required|string',
            'name' => 'required|string',
            'thumbnail' => 'required',
            'ft' => 'nullable|exists:users,username',
        ]);

        return $audioService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function show($id, AudioService $audioService)
    {
        return $audioService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, AudioService $audioService)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'ft' => 'nullable|exists:users,username',
        ]);

        return $audioService->update($request, $id);
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
    public function charts()
    {
        return DB::table('audio_likes')
            ->select('audio_id', DB::raw('count(*) as likes'))
            ->groupBy('audio_id')
            ->orderBy('likes', 'DESC')
            ->get();
    }
}
