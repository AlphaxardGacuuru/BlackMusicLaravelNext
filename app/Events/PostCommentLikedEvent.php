<?php

namespace App\Events;

use App\Models\PostComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCommentLikedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $comment;
	public $post;
	public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($comment, $post, $user)
    {
		$this->comment = $comment;
		$this->post = $post;
		$this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
