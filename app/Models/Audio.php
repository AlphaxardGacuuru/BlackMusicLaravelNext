<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = "audios";

    // Get released date even when null
    public function getReleasedDateAttribute()
    {
        return $this->released ? Carbon::parse($this->released)->format("d M Y") : "";
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'username');
    }

    public function albums()
    {
        return $this->belongsTo(AudioAlbum::class, 'audio_album_id');
    }

    public function likes()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function bought()
    {
        return $this->hasMany(BoughtAudio::class);
    }

    public function cart()
    {
        return $this->hasMany(CartAudio::class);
    }
}
