<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AudioBoughtEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $structuredAudios;
	public $audios;
	public $decoArtists;
	public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($structuredAudios, $audios, $decoArtists, $user)
    {
        $this->structuredAudios = $structuredAudios;
        $this->audios = $audios;
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
        return new PrivateChannel('audio-bought');
    }
}
