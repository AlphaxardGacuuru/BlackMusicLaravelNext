<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAlbum extends Model
{
    use HasFactory;

	protected $dates = ['released'];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

	/*
	*	Custom Functions
	*/

	public function cover($videoAlbum)
	{
		return "/storage/" . $videoAlbum->cover;
	}
}
