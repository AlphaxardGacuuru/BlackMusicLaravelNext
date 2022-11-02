<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

	public function users() {
		return $this->belongsTo(User::class, 'username');
	}

	public function albums() {
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
