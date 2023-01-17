<?php

namespace App\Http\Controllers;

use App\Http\Services\KaraokeService;
use App\Models\Karaoke;
use Illuminate\Http\Request;

class KaraokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KaraokeService $karaokeService)
    {
        return $karaokeService->index();
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
     * @param  \App\Models\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function show(Karaoke $karaoke)
    {
        //
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
