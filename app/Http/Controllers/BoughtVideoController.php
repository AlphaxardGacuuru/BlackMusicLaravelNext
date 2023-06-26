<?php

namespace App\Http\Controllers;

use App\Events\VideoBoughtEvent;
use App\Models\BoughtVideo;
use App\Http\Services\BoughtVideoService;
use Illuminate\Http\Request;

class BoughtVideoController extends Controller
{
    public function __construct(protected BoughtVideoService $service)
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
        $response = $this->service->store($request);

        $hasBought = count($response[0]) > 0;

        VideoBoughtEvent::dispatchIf($hasBought, $response[1], $response[2]);

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

	/*
	* Artist's Bought Videos */
	public function artistBoughtVideos($username)
	{
		return $this->service->artistBoughtVideos($username);
	} 
}
