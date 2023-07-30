<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentLike extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }

    public function comment()
    {
        return $this->belongsTo(PostComment::class, "post_comment_id");
    }
}
