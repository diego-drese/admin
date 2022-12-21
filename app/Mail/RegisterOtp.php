<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterOtp extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;

    public function __construct($user) {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $user = $this->user;
        $user->email_check_token = uniqid('CONFIRM_');
        $user->email_check_send_at = date('Y-m-d H:i:s');
        $user->save();
        return $this->subject('Confirmação de cadastro')
            ->markdown('email.otp', ['user' =>$user]);
    }
}
