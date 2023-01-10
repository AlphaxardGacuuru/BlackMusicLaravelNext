<?php

namespace App\Http\Controllers;

use App\Http\Services\AudioAlbumService;
use App\Models\AudioAlbum;
use Illuminate\Http\Request;

class AudioAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AudioAlbumService $audioAlbumService)
    {
		return $audioAlbumService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AudioAlbumService $audioAlbumService)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'released' => 'required',
            'cover' => 'required|image|max:1999',
        ]);

		return $audioAlbumService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id, AudioAlbumService $audioAlbumService)
    {
        return $audioAlbumService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, AudioAlbumService $audioAlbumService)
    {
        $this->validate($request, [
            'cover' => 'nullable|image|max:1999',
        ]);

		return $audioAlbumService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function destroy(AudioAlbum $audioAlbum)
    {
        //
    }
}
