<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

	// Get released date even when null
    public function getReleasedDateAttribute()
    {
        return $this->released ? Carbon::parse($this->released)->format("d M Y") : "";
    }

	public function user() {
		return $this->belongsTo(User::class, 'username', 'id');
	}

	public function album() {
		return $this->belongsTo(VideoAlbum::class, 'video_album_id');
	}

	public function likes() {
		return $this->hasMany(VideoLike::class);
	}

	public function bought() {
		return $this->hasMany(BoughtVideo::class);
	}

	public function cart() {
		return $this->hasMany(CartVideo::class);
	}
}
