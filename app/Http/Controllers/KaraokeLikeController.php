<?php

namespace App\Http\Controllers;

use App\Models\KaraokeLike;
use App\Services\KaraokeLikeService;
use Illuminate\Http\Request;

class KaraokeLikeController extends Controller
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
    public function store(Request $request, KaraokeLikeService $service)
    {
        return $service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KaraokeLike  $karaokeLike
     * @return \Illuminate\Http\Response
     */
    public function show(KaraokeLike $karaokeLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaraokeLike  $karaokeLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaraokeLike $karaokeLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaraokeLike  $karaokeLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(KaraokeLike $karaokeLike)
    {
        //
    }
}
