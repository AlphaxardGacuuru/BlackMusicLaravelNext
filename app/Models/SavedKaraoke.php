<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedKaraoke extends Model
{
    use HasFactory;

	public function karaoke()
	{
		return $this->belongsTo(Karaoke::class);
	}
}
