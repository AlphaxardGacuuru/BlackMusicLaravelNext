<?php

namespace App\Http\Controllers;

use App\Models\SavedKaraoke;\SavedKaraokeService;
use Illuminate\Http\Request;

class SavedKaraokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SavedKaraokeService $savedKaraokeService)
    {
        return $savedKaraokeService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SavedKaraokeService $savedKaraokeService)
    {
        // Handle form for karaoke
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        return $savedKaraokeService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SavedKaraoke  $savedKaraoke
     * @return \Illuminate\Http\Response
     */
    public function show(SavedKaraoke $savedKaraoke)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SavedKaraoke  $savedKaraoke
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SavedKaraoke $savedKaraoke)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SavedKaraoke  $savedKaraoke
     * @return \Illuminate\Http\Response
     */
    public function destroy(SavedKaraoke $savedKaraoke)
    {
        //
    }
}
