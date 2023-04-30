<?php

namespace App\Services;

use App\Models\Story;

class StoryService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getStories = Story::all();

        $stories = [];

        foreach ($getStories as $story) {
            array_push($stories, $this->structure($story));
        }

        return $stories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $story = new Story;
        $story->username = $this->username;
        $story->media = $request->input("media");
        $story->text = $request->input("text");
        $saved = $story->save();

        return ["saved" => $saved, "story" => $story];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
     * Structure */
    public function structure($story)
    {
        return [
            "id" => $story->id,
            "username" => $story->username,
            "avatar" => $story->user->avatar,
            "media" => $story->media,
            "text" => $story->text,
			"seenAt" => $story->seen_at
        ];
    }
}
