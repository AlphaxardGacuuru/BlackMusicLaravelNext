<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AudioCommentLikedNotification extends Notification
{
    use Queueable;

	public $comment;
	public $audio;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $audio)
    {
        $this->comment = $comment;
        $this->audio = $audio;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
			'url' => '/audio/' . $this->comment->id,
			'from' => auth('sanctum')->user()->username,
			'message' => auth('sanctum')->user()->username . ' liked your comment on ' . $this->audio->name,
        ];
    }
}