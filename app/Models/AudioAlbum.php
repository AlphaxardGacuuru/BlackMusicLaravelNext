<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioAlbum extends Model
{
    use HasFactory;

	protected $dates = ['released'];

    public function audios()
    {
        return $this->hasMany(Audio::class);
    }

	/*
	*	Custom Functions
	*/

	public function cover($audioAlbum)
	{
		return "/storage/" . $audioAlbum->cover;
	}
}
