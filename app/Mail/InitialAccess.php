<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InitialAccess extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public string $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build(): InitialAccess
    {
        return $this->view('emails.initial-access')
            ->subject('Dostęp do Eduplatform');
    }
}
