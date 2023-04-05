<?php

namespace App\Notifications;

use App\Mail\VideoReceiptMail;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoughtVideoNotification extends Notification
{
    use Queueable;

    public $video;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
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
        return (new VideoReceiptMail($this->video))
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
            'id' => $this->video->username,
            'message' => auth('sanctum')->user()->username . ' bought ' . $this->video->name,
        ];
    }
}
