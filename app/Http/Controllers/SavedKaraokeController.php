<?php

namespace App\Http\Controllers;

use App\Models\SavedKaraoke;
use App\Http\Services\SavedKaraokeService;
use Illuminate\Http\Request;

class SavedKaraokeController extends Controller
{
    public function __construct(protected SavedKaraokeService $service)
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
        // Handle form for karaoke
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        return $this->service->store($request);
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
