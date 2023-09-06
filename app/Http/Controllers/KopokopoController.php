<?php

namespace App\Http\Controllers;

use App\Events\AudioBoughtEvent;
use App\Events\KopokopoCreatedEvent;
use App\Events\VideoBoughtEvent;
use App\Http\Services\BoughtAudioService;
use App\Http\Services\BoughtVideoService;
use App\Http\Services\KopokopoService;
use App\Models\Kopokopo;
use Illuminate\Http\Request;

class KopokopoController extends Controller
{
    public function __construct(protected KopokopoService $service)
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
        [$saved, $kopokopo, $user] = $this->service->store($request);

        KopokopoCreatedEvent::dispatchIf($saved, $kopokopo, $user);

        //  Buy Videos
        $boughtVideoService = new BoughtVideoService;

        [$structuredBoughtVideos, $boughtVideos, $decoArtists] = $boughtVideoService->store($user);

        // Check if Videos were actually bought
        $hasBought = count($boughtVideos) > 0;

        VideoBoughtEvent::dispatchIf(
            $hasBought,
            $structuredBoughtVideos,
            $boughtVideos,
            $decoArtists,
            $user
        );

        //  Buy Audios
        $boughtAudioService = new BoughtAudioService;

        [$structuredBoughtAudios, $boughtAudios, $decoArtists] = $boughtAudioService->store($user);

        // Check if Audios were actually bought
        $hasBought = count($boughtAudios) > 0;

        AudioBoughtEvent::dispatchIf(
            $hasBought,
			$structuredBoughtAudios,
            $boughtAudios,
            $decoArtists,
            $user
        );

        return response(["status" => "OK"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kopokopo  $kopokopo
     * @return \Illuminate\Http\Response
     */
    public function show(Kopokopo $kopokopo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kopokopo  $kopokopo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kopokopo $kopokopo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kopokopo  $kopokopo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kopokopo $kopokopo)
    {
        //
    }

    /**
     * Send STK Push to Kopokopo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kopokopo  $kopokopo
     * @return \Illuminate\Http\Response
     */
    public function stkPush(Request $request)
    {
        return $this->service->stkPush($request);
    }
}
