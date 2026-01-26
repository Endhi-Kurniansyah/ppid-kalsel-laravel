<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database']; // Kita simpan di database agar muncul di icon lonceng
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->details['title'],
            'message' => $this->details['message'],
            'url' => $this->details['url'],
            'type' => $this->details['type'], // 'request' atau 'objection'
        ];
    }
}
