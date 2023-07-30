<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLike extends Model
{
    use HasFactory;
	
    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }

	public function video()
	{
		return $this->belongsTo(Video::class);
	}
}
