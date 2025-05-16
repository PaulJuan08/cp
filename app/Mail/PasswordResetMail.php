<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newPassword;
    public $userName;

    public function __construct($newPassword, $userName)
    {
        $this->newPassword = $newPassword;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Your Password Has Been Reset')
                    ->markdown('emails.password-reset')
                    ->with([
                        'newPassword' => $this->newPassword,
                        'userName' => $this->userName,
                    ]);
    }
}