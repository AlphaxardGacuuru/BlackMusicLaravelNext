<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoughtAudioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Check if user is logged in
        $username = auth('sanctum')->user()
        ? auth('sanctum')->user()->username
        : '@guest';

        return [
            "id" => $this->audio->id,
            "audio" => $this->audio->audio,
            "name" => $this->audio->name,
            "artistName" => $this->audio->user->name,
            "username" => $this->audio->username,
            "avatar" => $this->audio->user->avatar,
            "artistDecos" => $this->audio->user->decos,
            "ft" => $this->audio->ft,
            "audioAlbumId" => $this->audio->audio_album_id,
            "album" => $this->audio->album->name,
            "genre" => $this->audio->genre,
            "thumbnail" => $this->audio->thumbnail,
            "description" => $this->audio->description,
            "released" => $this->audio->released,
            "hasBoughtAudio" => true,
            "createdAt" => $this->audio->created_at,
        ];
    }
}
