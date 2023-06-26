<?php

namespace App\Http\Controllers;

use App\Models\Karaoke;
use App\Http\Services\KaraokeService;
use Illuminate\Http\Request;

class KaraokeController extends Controller
{
    public function __construct(protected KaraokeService $service)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Handle form for audio
        $this->validate($request, [
            "karaoke" => "required|string",
            "audio_id" => "required",
            "description" => "required|string",
        ]);

        return $this->service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karaoke $karaoke)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karaoke $karaoke)
    {
        //
    }
}
