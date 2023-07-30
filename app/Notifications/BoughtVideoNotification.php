<?php

namespace App\Notifications;

use App\Mail\VideoReceiptMail;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoughtVideoNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $video;
	public $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Video $video, $username)
    {
        $this->video = $video;
        $this->username = $username;
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
		// 
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
            'url' => '/profile/' . $this->username,
            'from' => $this->username,
            'id' => $this->video->username,
            'message' => $this->username . ' bought ' . $this->video->name,
        ];
    }
}
