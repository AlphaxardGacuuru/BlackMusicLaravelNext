<?php

namespace App\Notifications;

use App\Mail\BoughtAudioMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoughtAudioNotification extends Notification
{
    use Queueable;

	public $audio;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($audio)
    {
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new BoughtAudioMail($this->audio))
                    ->to($notifiable->email);
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
			'url' => '/profile/' . auth('sanctum')->user()->username,
			'from' => auth('sanctum')->user()->username,
			'id' => $this->audio->username,
			'message' => auth('sanctum')->user()->username . ' bought ' . $this->audio->name,
        ];
    }
}
