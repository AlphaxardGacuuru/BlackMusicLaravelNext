<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    /**
     * Accesors.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function media(): Attribute
    {
        return Attribute::make(
            get:fn($value) => $value ? "/storage/" . $value : $value,
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get:fn($value) => Carbon::parse($value)->format('d M Y'),
        );
    }

    /**
     * Relationships.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }
}
