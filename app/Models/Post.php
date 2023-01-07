<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(PostCommentLike::class);
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    /*
     *    Custom Functions
     */

    // Profile Pic
    public function avatar($post)
    {
        $avatar = $post->users->avatar;
        return preg_match("/http/", $avatar) ? $avatar : "/storage/" . $avatar;
    }

    // Check if user has voted for various parameters
    public function hasVoted($post, $username, $parameter)
    {
        return $post->polls
            ->where('username', $username)
            ->where('parameter', $parameter)
            ->count() > 0 ? true : false;
    }

    // Get votes of each parameter as a percentage
    public function percentage($post, $parameter)
    {
        $countParameter = $post->polls
            ->where('parameter', $post->parameter)
            ->count();

        return $countParameter > 0 ? $countParameter / $post->polls->count() * 100 : 0;
    }

    // Check if poll is within 24Hrs
    public function isWithin24Hrs($post)
    {
        return $post->created_at > Carbon::now()->subDays(1)->toDateTimeString();
    }

    // Check if user has liked post
    public function hasLiked($post, $username)
    {
        return $post->likes
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }

    // Check if user has followed Musician
    public function hasFollowed($post, $username)
    {
        return Follow::where('followed', $post->username)
            ->where('username', $username)
            ->exists();
    }

    // Check whether the post is edited
    public function hasEdited($post)
    {
        return $post->created_at != $post->updated_at ? true : false;
    }
}
