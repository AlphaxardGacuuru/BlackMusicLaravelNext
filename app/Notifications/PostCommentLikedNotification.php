<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostCommentLikedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

	public $comment;
	public $post;
	public $user;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
			'url' => '/post/show/' . $this->post->id,
			'from' => $this->user->username,
			'message' => $this->user->username . ' liked your comment on ' . $this->post->text,
        ];
    }
}
