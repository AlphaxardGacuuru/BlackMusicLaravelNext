<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoBoughtEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $structuredVideos;
	public $videos;
	public $decoArtists;
	public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($structuredVideos, $videos, $decoArtists, $user)
    {
        $this->structuredVideos = $structuredVideos;
        $this->videos = $videos;
		$this->decoArtists = $decoArtists;
		$this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('video-bought');
    }
}
