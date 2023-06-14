<?php

namespace App\Http\Controllers;

use App\Events\StoryCreatedEvent;
use App\Models\Story;
use App\Services\StoryService;
use Illuminate\Http\Request;

class StoryController extends Controller
{
	public function __construct(protected StoryService $service)
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
            "media" => "required|string",
            "text" => "string",
        ]);

        $response = $this->service->store($request);

        StoryCreatedEvent::dispatchIf($response["saved"], $response["story"]);

        return response("Story created", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
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
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
    }

	/*
	* Seen */
	public function seen($id)
	{
		return $this->service->seen($id);
	} 

	/*
	* Mute */
	public function mute($username)
	{
		return $this->service->mute($username);
	} 
}
