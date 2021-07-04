<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceNotification extends Notification
{
    use Queueable;

    private $group;
    private $date;
    private $attendance;
    private $changes;

    public function __construct($group, $date, $attendance, $changes = null)
    {
        $this->group = $group;
        $this->date = $date;
        $this->attendance = $attendance;
        $this->changes = $changes;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'group' => $this->group,
            'date' => $this->date,
            'attendance' => $this->attendance,
            'changes' => $this->changes,
        ];
    }
}
