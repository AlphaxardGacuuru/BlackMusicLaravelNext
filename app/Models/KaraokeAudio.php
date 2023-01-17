<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaraokeAudio extends Model
{
    use HasFactory;

    protected $table = 'karaoke_audios';

    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }
}
