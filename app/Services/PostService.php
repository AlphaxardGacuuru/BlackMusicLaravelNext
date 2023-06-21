<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService extends Service
{
    public function index()
    {
        // Get Posts if user has followed musician and is not muted
        $getPosts = Post::select("posts.*", "follows.muted->posts as muted", "follows.blocked")
            ->join("follows", function ($join) {
                $join->on("follows.followed", "=", "posts.username")
                    ->where("follows.username", "=", $this->username);
            })
            ->where("follows.muted->posts", false)
            ->orderBy("posts.id", "DESC")
            ->get();

        $posts = [];

        foreach ($getPosts as $post) {
            array_push($posts, $this->structure($post));
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
        $post = Post::find($id);

        return $this->structure($post);
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

        $saved = $post->save();

        return [$saved, $post];
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

    /*
     * Mute */
    public function mute($username)
    {
        // Get follow
        $follow = Follow::where("followed", $username)
            ->where("username", $this->username)
            ->first();

        // Check if Posts are muted
        if ($follow->muted["posts"]) {
            $muted = $follow->muted;
            $muted["posts"] = false;
            $follow->muted = $muted;

            $message = "Posts from " . $username . " unmuted";
        } else {
            $muted = $follow->muted;
            $muted["posts"] = true;
            $follow->muted = $muted;

            $message = "Posts from " . $username . " muted";
        }

        $follow->save();

        return response($message, 200);
    }

    /*
     * Artist's Posts */
    public function artistPosts($username)
    {
        // Get Artist's Posts with muted info
        $getArtistPosts = Post::select("posts.*", "follows.muted->posts as muted", "follows.blocked")
            ->join("follows", function ($join) {
                $join->on("follows.followed", "=", "posts.username")
                    ->where("follows.username", "=", $this->username);
            })
            ->where("posts.username", $username)
            ->orderBy("posts.id", "DESC")
            ->get();

        $artistPosts = [];

        foreach ($getArtistPosts as $post) {
            array_push($artistPosts, $this->structure($post));
        }

        return $artistPosts;
    }

    /*
     * Structure Posts */
    public function structure($post)
    {
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

        return [
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
            "hasVoted1" => $post->hasVoted($post, $this->username, $post->parameter_1),
            "hasVoted2" => $post->hasVoted($post, $this->username, $post->parameter_2),
            "hasVoted3" => $post->hasVoted($post, $this->username, $post->parameter_3),
            "hasVoted4" => $post->hasVoted($post, $this->username, $post->parameter_4),
            "hasVoted5" => $post->hasVoted($post, $this->username, $post->parameter_5),
            "percentage1" => $percentage1,
            "percentage2" => $percentage2,
            "percentage3" => $percentage3,
            "percentage4" => $percentage4,
            "percentage5" => $percentage5,
            "winner" => $winner,
            "totalVotes" => $post->polls->count(),
            "isWithin24Hrs" => $post->isWithin24Hrs($post),
            "hasMuted" => filter_var($post->muted, FILTER_VALIDATE_BOOLEAN),
            "hasFollowed" => $post->hasFollowed($post, $this->username),
            "hasLiked" => $post->hasLiked($post, $this->username),
            "hasEdited" => $post->hasEdited($post),
            "likes" => $post->likes->count(),
            "comments" => $post->comments->count(),
            "updatedAt" => $post->updated_at,
            "createdAt" => $post->created_at,
        ];
    }
}
