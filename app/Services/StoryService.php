<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\SeenStory;
use App\Models\Story;
use Carbon\Carbon;

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
        $getStory = Story::find($id);

        return $this->structure($getStory);
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
        $story = Story::find($id);
        $story->save();

        return response("Story updated", 200);
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
     * Seen */
    public function seen($id)
    {
        $seenStory = new SeenStory;
        $seenStory->story_id = $id;
        $seenStory->username = $this->username;
        $seenStory->seen_at = Carbon::now();
        $seenStory->save();

        return response("Story seen", 200);
    }

    /*
     * Mute */
    public function mute($username)
    {
        // Get follow
        $follow = Follow::where("followed", $username)
            ->where("username", $this->username)
            ->first();

        $follow->muted = ["stories" => true];
        $follow->save();

        return response("Stories from " . $username . " muted");
    }

    /*
     * Structure */
    public function structure($story)
    {
        return [
            "id" => $story->id,
            "name" => $story->user->name,
            "username" => $story->username,
            "avatar" => $story->user->avatar,
            "media" => $story->media,
            "text" => $story->text,
            "hasSeen" => $story->hasSeen($this->username),
        ];
    }
}
