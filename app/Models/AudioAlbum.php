<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioAlbum extends Model
{
    use HasFactory;

    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
