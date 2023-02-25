<?php

namespace App\Http\Controllers;

use App\Http\Services\CartAudioService;
use App\Models\CartAudio;
use Illuminate\Http\Request;

class CartAudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartAudioService $cartAudioService)
    {
        return $cartAudioService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartAudioService $cartAudioService)
    {
        return $cartAudioService->store($request);
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
