<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = "audios";

	protected $dates = ['released'];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function album()
    {
        return $this->belongsTo(AudioAlbum::class, 'audio_album_id');
    }

    public function likes()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function comments()
    {
        return $this->hasMany(AudioComment::class);
    }

    public function bought()
    {
        return $this->hasMany(BoughtAudio::class);
    }

    public function cart()
    {
        return $this->hasMany(CartAudio::class);
    }

    /*
     *    Custom Functions
     */

    public function thumbnail()
    {
        return preg_match("/http/", $this->thumbnail) ? $this->thumbnail : "/storage/" . $this->thumbnail;
    }

    public function avatar($audio)
    {
        return "/storage/" . $audio->user->avatar;
    }

    // Check if user has liked audio
    public function hasLiked($audio, $username)
    {
        return $audio->likes
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }

    // Check if audio in cart
    public function inCart($audio, $username)
    {
        return $audio->cart
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }

    // Check if user has bought audio
    public function hasBoughtAudio($audio, $username)
    {
        return $audio->bought
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }
}
