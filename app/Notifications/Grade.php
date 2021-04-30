<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Grade extends Notification
{
    use Queueable;

    private $grade;
    private $gradeItem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($gradeItem, $grade)
    {
        $this->gradeItem = $gradeItem;
        $this->grade = $grade;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'gradeItem' => $this->gradeItem,
            'grade' => $this->grade
        ];
    }
}
