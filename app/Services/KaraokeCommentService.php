<?php

namespace App\Services;

use App\Models\KaraokeComment;

class KaraokeCommentService extends Service
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getKaraokeComments = KaraokeComment::orderBy('id', 'DESC')->get();

        $karaokeComments = [];

        foreach ($getKaraokeComments as $karaokeComment) {
            array_push($karaokeComments, $this->structure($karaokeComment));
        }

        return response($karaokeComments, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KaraokeComment  $karaokeComment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getKaraokeComments = KaraokeComment::where("karaoke_id", $id)->orderBy("id", "DESC")->get();

        $karaokeComments = [];

        foreach ($getKaraokeComments as $karaokeComment) {
            array_push($karaokeComments, $this->structure($karaokeComment));
        }

        return response($karaokeComments, 200);
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
        $karaokeComment = new KaraokeComment;
        $karaokeComment->karaoke_id = $request->input('id');
        $karaokeComment->username = auth('sanctum')->user()->username;
        $karaokeComment->text = $request->input('text');
        $karaokeComment->save();

        // Show notification
        // $karaoke = Karaokes::where('id', $request->input('id'))->first();
        // $karaoke->users->username != auth()->user()->username &&
        // $karaoke->users->notify(new KaraokeCommentNotifications($karaoke->name));

        return response('Comment Posted', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KaraokeComments  $karaokeComments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KaraokeComment::find($id)->delete();

        return response('Comment deleted', 200);
    }

    /*
     * Structure */
    public function structure($karaokeComment)
    {
        return [
            "id" => $karaokeComment->id,
            "karaoke_id" => $karaokeComment->karaoke_id,
            "text" => $karaokeComment->text,
            "username" => $karaokeComment->username,
            "name" => $karaokeComment->user->name,
            "avatar" => $karaokeComment->user->avatar,
            "hasLiked" => $karaokeComment->hasLiked($this->username),
            "likes" => $karaokeComment->likes->count(),
            "created_at" => $karaokeComment->created_at,
        ];
    }
}
