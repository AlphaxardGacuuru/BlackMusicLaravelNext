<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

	protected $dates = ['released'];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function album()
    {
        return $this->belongsTo(VideoAlbum::class, 'video_album_id');
    }

    public function likes()
    {
        return $this->hasMany(VideoLike::class);
    }

    public function bought()
    {
        return $this->hasMany(BoughtVideo::class);
    }

    public function cart()
    {
        return $this->hasMany(CartVideo::class);
    }

    /*
     *    Custom Functions
     */

    public function thumbnail($video)
    {
        return preg_match("/http/", $video->thumbnail) ? $video->thumbnail : "/storage/" . $video->thumbnail;
    }

    public function avatar($video)
    {
        return "/storage/" . $video->user->avatar;
    }

    // Check if user has liked video
    public function hasLiked($video, $username)
    {
        return $video->likes
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }

    // Check if video in cart
    public function inCart($video, $username)
    {
        return $video->cart
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }

    // Check if user has bought video
    public function hasBoughtVideo($video, $username)
    {
        return $video->bought
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }
}
