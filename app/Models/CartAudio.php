<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAudio extends Model
{
    use HasFactory;

    protected $table = "cart_audios";

    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }
}
