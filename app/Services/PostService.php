<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();
        $authUsername = $auth ? $auth->username : '@guest';

        // Get Posts
        $getPosts = Post::orderBy('id', 'DESC')->get();

        $posts = [];

        foreach ($getPosts as $post) {

            // Get votes of each parameter as a percentage
            $percentage1 = $post->percentage($post, $post->parameter_1);
            $percentage2 = $post->percentage($post, $post->parameter_2);
            $percentage3 = $post->percentage($post, $post->parameter_3);
            $percentage4 = $post->percentage($post, $post->parameter_4);
            $percentage5 = $post->percentage($post, $post->parameter_5);

            $pollsPercentages = [
                $post->parameter_1 => $percentage1,
                $post->parameter_2 => $percentage2,
                $post->parameter_3 => $percentage3,
                $post->parameter_4 => $percentage4,
                $post->parameter_5 => $percentage5,
            ];

            // Get parameter with the most votes
            $winner = array_keys($pollsPercentages, max($pollsPercentages));

            $winner = count($winner) > 1 ? "" : $winner[0];

            array_push($posts, [
                "id" => $post->id,
                "name" => $post->user->name,
                "username" => $post->user->username,
                "avatar" => $post->user->avatar,
                "decos" => $post->user->decos->count(),
                "text" => $post->text,
                "media" => $post->media,
                "parameter_1" => $post->parameter_1,
                "parameter_2" => $post->parameter_2,
                "parameter_3" => $post->parameter_3,
                "parameter_4" => $post->parameter_4,
                "parameter_5" => $post->parameter_5,
                "hasVoted1" => $post->hasVoted($post, $authUsername, $post->parameter_1),
                "hasVoted2" => $post->hasVoted($post, $authUsername, $post->parameter_2),
                "hasVoted3" => $post->hasVoted($post, $authUsername, $post->parameter_3),
                "hasVoted4" => $post->hasVoted($post, $authUsername, $post->parameter_4),
                "hasVoted5" => $post->hasVoted($post, $authUsername, $post->parameter_5),
                "percentage1" => $percentage1,
                "percentage2" => $percentage2,
                "percentage3" => $percentage3,
                "percentage4" => $percentage4,
                "percentage5" => $percentage5,
                "winner" => $winner,
                "totalVotes" => $post->polls->count(),
                "isWithin24Hrs" => $post->isWithin24Hrs($post),
                "hasFollowed" => $post->hasFollowed($post, $authUsername),
                "hasLiked" => $post->hasLiked($post, $authUsername),
                "hasEdited" => $post->hasEdited($post),
                "likes" => $post->likes->count(),
                "comments" => $post->comments->count(),
                "updatedAt" => $post->updated_at,
                "createdAt" => $post->created_at,
            ]);
        }

        return $posts;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioAlbum  $audioAlbum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::find($id);
    }

    /* Create new post */
    public function store($request)
    {
        $post = new Post;
        $post->username = auth('sanctum')->user()->username;
        $post->text = $request->input('text');
        $post->media = $request->input('media');
        $post->parameter_1 = $request->input('para1') ? $request->input('para1') : "";
        $post->parameter_2 = $request->input('para2') ? $request->input('para2') : "";
        $post->parameter_3 = $request->input('para3') ? $request->input('para3') : "";
        $post->parameter_4 = $request->input('para4') ? $request->input('para4') : "";
        $post->parameter_5 = $request->input('para5') ? $request->input('para5') : "";
        $post->save();

        return response('Post Created', 200);
    }

    // Update Post
    public function update($request, $id)
    {
        $post = Post::find($id);
        $post->text = $request->input('text');
        $post->save();

        return response("Post Edited", 200);
    }

    // Delete Post
    public function destory($id)
    {
        $post = Post::where('id', $id)->first();

        $media = substr($post->media, 9);

        Storage::delete("public/" . $media);

        Post::find($id)->delete();

        return response("Post deleted", 200);
    }
}
