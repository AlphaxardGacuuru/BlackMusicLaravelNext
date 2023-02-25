<?php

namespace App\Http\Controllers;

use App\Http\Services\CartVideoService;
use App\Models\CartVideo;
use Illuminate\Http\Request;

class CartVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartVideoService $cartVideoService)
    {
        return $cartVideoService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartVideoService $cartVideoService)
    {
		return $cartVideoService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartVideo  $cartVideo
     * @return \Illuminate\Http\Response
     */
    public function show(CartVideo $cartVideo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartVideo  $cartVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartVideo $cartVideo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartVideo  $cartVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartVideo $cartVideo)
    {
        //
    }
}
