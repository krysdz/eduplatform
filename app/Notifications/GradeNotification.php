<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GradeNotification extends Notification
{
    use Queueable;

    private $group;
    private $gradeItem;
    private $grade;
    private $score;
    private $changes;


    public function __construct($group, $gradeItem, $grade, $score, $changes = null)
    {
        $this->group = $group;
        $this->gradeItem = $gradeItem;
        $this->grade = $grade;
        $this->score = $score;
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
            'gradeItem' => $this->gradeItem,
            'grade' => $this->grade,
            'score' => $this->score,
            'changes' => $this->changes,
        ];
    }
}
