<?php

namespace App\Http\Controllers;

use App\Models\CartAudio;
use App\Http\Services\CartAudioService;
use Illuminate\Http\Request;

class CartAudioController extends Controller
{
    public function __construct(protected CartAudioService $service)
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
        return $this->service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartAudio  $cartAudio
     * @return \Illuminate\Http\Response
     */
    public function show(CartAudio $cartAudio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartAudio  $cartAudio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartAudio $cartAudio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartAudio  $cartAudio
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartAudio $cartAudio)
    {
        //
    }
}
