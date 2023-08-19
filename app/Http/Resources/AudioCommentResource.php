<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AudioCommentResource extends JsonResource
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
                "id" => $this->id,
                "audioId" => $this->audio_id,
                "text" => $this->text,
                "username" => $this->username,
                "name" => $this->user->name,
                "avatar" => $this->user->avatar,
                "decos" => $this->user->decos,
                "hasLiked" => $this->hasLiked($username),
                "likes" => $this->likes->count(),
                "createdAt" => $this->created_at,
		];
    }
}
