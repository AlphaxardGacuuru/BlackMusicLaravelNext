<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoughtAudio extends Model
{
    use HasFactory;

	protected $table = 'bought_audios';

	public function audio()
	{
		return $this->belongsTo(Audio::class);
	}
}
