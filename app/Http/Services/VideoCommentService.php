<?php

namespace App\Http\Services;

use App\Models\VideoComment;

class VideoCommentService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        $getVideoComments = VideoComment::orderBy('id', 'DESC')->get();

        $videoComments = [];

        foreach ($getVideoComments as $key => $videoComment) {

            array_push($videoComments, [
                "id" => $videoComment->id,
                "videoId" => $videoComment->video_id,
                "text" => $videoComment->text,
                "username" => $videoComment->username,
                "name" => $videoComment->user->name,
                "avatar" => $videoComment->user->avatar,
                "hasLiked" => $videoComment->hasLiked($authUsername),
                "likes" => $videoComment->likes->count(),
                "createdAt" => $videoComment->created_at,
            ]);
        }

        return $videoComments;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoComment  $videoComment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        $getVideoComments = VideoComment::where("video_id", $id)
            ->orderBy('id', 'DESC')
            ->get();

        $videoComments = [];

        foreach ($getVideoComments as $key => $videoComment) {

            array_push($videoComments, [
                "id" => $videoComment->id,
                "videoId" => $videoComment->video_id,
                "text" => $videoComment->text,
                "username" => $videoComment->username,
                "name" => $videoComment->user->name,
                "avatar" => $videoComment->user->avatar,
				"decos" => $videoComment->user->decos->count(),
                "hasLiked" => $videoComment->hasLiked($authUsername),
                "likes" => $videoComment->likes->count(),
                "createdAt" => $videoComment->created_at,
            ]);
        }

        return $videoComments;
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
        $videoComment = new VideoComment;
        $videoComment->video_id = $request->input('id');
        $videoComment->username = auth('sanctum')->user()->username;
        $videoComment->text = $request->input('text');
        $videoComment->save();

        // Show notification
        // $video = Videos::where('id', $request->input('id'))->first();
        // $video->users->username != auth()->user()->username &&
        // $video->users->notify(new VideoCommentNotifications($video->name));

        return response('Comment Posted', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VideoComments  $videoComments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VideoComment::find($id)->delete();

        return response('Comment deleted', 200);
    }
}
