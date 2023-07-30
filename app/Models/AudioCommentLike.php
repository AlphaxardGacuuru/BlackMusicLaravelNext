<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioCommentLike extends Model
{
    use HasFactory;
	
    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }
	
    public function comment()
    {
        return $this->belongsTo(AudioComment::class, "audio_comment_id");
    }
}
