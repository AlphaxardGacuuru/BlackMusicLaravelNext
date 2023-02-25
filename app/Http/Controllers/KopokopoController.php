<?php

namespace App\Http\Controllers;

use App\Http\Services\KopokopoService;
use App\Models\Kopokopo;
use Illuminate\Http\Request;

class KopokopoController extends Controller
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
    public function store(Request $request, KopokopoService $kopokopoService)
    {
        return $kopokopoService->store($request);
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
    public function stkPush(Request $request, KopokopoService $kopokopoService)
    {
		return $kopokopoService->stkPush($request);
    }
}
