<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoughtVideoResource extends JsonResource
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
            "id" => $this->video->id,
            "video" => $this->video->video,
            "name" => $this->video->name,
            "artistName" => $this->video->user->name,
            "username" => $this->video->username,
            "avatar" => $this->video->user->avatar,
            "artistDecos" => $this->video->user->decos,
            "ft" => $this->video->ft,
            "videoAlbumId" => $this->video->video_album_id,
            "album" => $this->video->album->name,
            "genre" => $this->video->genre,
            "thumbnail" => $this->video->thumbnail,
            "description" => $this->video->description,
            "released" => $this->video->released,
            "hasBoughtVideo" => true,
            "createdAt" => $this->video->created_at,
        ];
    }
}
