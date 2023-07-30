<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCommentLike extends Model
{
    use HasFactory;
	
    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }
	
	public function comment()
	{
		return $this->belongsTo(VideoComment::class, "video_comment_id");
	}
}
