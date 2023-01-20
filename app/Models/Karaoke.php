<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karaoke extends Model
{
    use HasFactory;

    /**
     * Accesors.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function karaoke(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => '/storage/' . $value,
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d M Y'),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }

    public function savedKaraoke()
    {
        return $this->hasMany(SavedKaraoke::class);
    }

    public function likes()
    {
        return $this->hasMany(KaraokeLike::class);
    }

    public function comments()
    {
        return $this->hasMany(KaraokeComment::class);
    }

    /*
     *    Custom Functions
     */

    // Check if user has liked karaoke
    public function hasLiked($karaoke, $username)
    {
        return $karaoke->likes
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }

    // Check if user has saved karaoke
    public function hasSaved($karaoke, $username)
    {
        return $karaoke->savedKaraoke
            ->where('username', $username)
            ->count() > 0 ? true : false;
    }
}
