<?php

namespace App\Http\Controllers;

use App\Events\VideoBoughtEvent;
use App\Http\Services\BoughtVideoService;
use App\Models\BoughtVideo;
use Illuminate\Http\Request;

class BoughtVideoController extends Controller
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
    public function store(Request $request, BoughtVideoService $service)
    {
        $response = $service->store($request);

        $hasBought = count($response[0]) > 0;

        VideoBoughtEvent::dispatchIf($hasBought, $response[0], $response[1]);

        return response($response[0], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BoughtVideo  $boughtVideo
     * @return \Illuminate\Http\Response
     */
    public function show(BoughtVideo $boughtVideo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BoughtVideo  $boughtVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoughtVideo $boughtVideo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BoughtVideo  $boughtVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoughtVideo $boughtVideo)
    {
        //
    }
}
