<?php

namespace App\Http\Controllers;

use App\Models\AudioAlbum;
use App\Http\Services\AudioAlbumService;
use Illuminate\Http\Request;

class AudioAlbumController extends Controller
{
    public function __construct(protected AudioAlbumService $service)
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
        $this->validate($request, [
            'name' => 'required|string',
            'released' => 'required',
            'cover' => 'required|image|max:1999',
        ]);

        return $this->service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cover' => 'nullable|image|max:1999',
        ]);

        return $this->service->update($request, $id);
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

	/*
	* Artist's Audio Albums */
	public function artistAudioAlbums($username)
	{
		return $this->service->artistAudioAlbums($username);
	} 
}
