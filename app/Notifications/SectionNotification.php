<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SectionNotification extends Notification
{
    use Queueable;

    private $group;
    private $name;

    public function __construct($group, $name)
    {
        $this->group = $group;
        $this->name = $name;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'group' => $this->group,
            'name' => $this->name,
        ];
    }
}
