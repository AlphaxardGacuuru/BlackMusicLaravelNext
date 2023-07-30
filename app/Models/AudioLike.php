<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioLike extends Model
{
    use HasFactory;
	
    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }

	public function audio()
	{
		return $this->belongsTo(Audio::class);
	}
}
