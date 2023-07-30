<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    /**
     * Accesors.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function media(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? "/storage/" . $value : $value,
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d M Y'),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }

    public function post()
    {
        return $this->belongsTo(Post::class, "post_id");
    }

    public function likes()
    {
        return $this->hasMany(PostCommentLike::class);
    }

    /*
     * Custom functions
     */

    /*
     * Check if user has liked post */
    public function hasLiked($username)
    {
        return $this->likes
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }
}
