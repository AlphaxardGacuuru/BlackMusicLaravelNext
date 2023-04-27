<?php

namespace App\Services;

use App\Models\AudioComment;

class AudioCommentService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAudioComments = AudioComment::orderBy('id', 'DESC')->get();

        $audioComments = [];

        foreach ($getAudioComments as $key => $audioComment) {

            array_push($audioComments, [
                "id" => $audioComment->id,
                "audioId" => $audioComment->audio_id,
                "text" => $audioComment->text,
                "username" => $audioComment->username,
                "name" => $audioComment->user->name,
                "avatar" => $audioComment->user->avatar,
                "decos" => $audioComment->user->decos->count(),
                "hasLiked" => $audioComment->hasLiked($this->username),
                "likes" => $audioComment->likes->count(),
                "createdAt" => $audioComment->created_at,
            ]);
        }

        return $audioComments;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioComment  $audioComment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getAudioComments = AudioComment::where("audio_id", $id)
            ->orderBy('id', 'DESC')
            ->get();

        $audioComments = [];

        foreach ($getAudioComments as $audioComment) {

            array_push($audioComments, [
                "id" => $audioComment->id,
                "audioId" => $audioComment->audio_id,
                "text" => $audioComment->text,
                "username" => $audioComment->username,
                "name" => $audioComment->user->name,
                "avatar" => $audioComment->user->avatar,
                "decos" => $audioComment->user->decos->count(),
                "hasLiked" => $audioComment->hasLiked($this->username),
                "likes" => $audioComment->likes->count(),
                "createdAt" => $audioComment->created_at,
            ]);
        }

        return $audioComments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        /* Create new post */
        $audioComment = new AudioComment;
        $audioComment->audio_id = $request->input('id');
        $audioComment->username = auth('sanctum')->user()->username;
        $audioComment->text = $request->input('text');

        return $audioComment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AudioComments  $audioComments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AudioComment::find($id)->delete();

        return response('Comment deleted', 200);
    }
}