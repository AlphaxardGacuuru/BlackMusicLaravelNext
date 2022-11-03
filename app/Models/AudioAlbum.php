<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioAlbum extends Model
{
    use HasFactory;

	// Get released date even when null
    public function getReleasedDateAttribute()
    {
        return $this->released ? Carbon::parse($this->released)->format("d M Y") : "";
    }

    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
