<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VideoReceiptNotification extends Notification
{
    use Queueable;

	public $videos;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($videos)
    {
        $this->videos = $videos;
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
        $list = [];

        foreach ($this->videos as $video) {
            array_push($list, $video['name']);
        }

        // Check proper grammar
        if (count($this->videos) > 1) {
            $numberOfVideos = count($this->videos) . ' videos: ';
        } else {
            $numberOfVideos = count($this->videos) . ' video: ';
        }

        return [
            'url' => '/library',
            'from' => '@blackmusic',
            'message' => 'You bought ' . $numberOfVideos . implode(", ", $list),
        ];
    }
}
