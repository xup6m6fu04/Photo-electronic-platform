<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * 寄信給單一使用者
     *
     * @param $args
     */
    public function single_mail($args)
    {
        $msg = array_get($args, 'msg', '');
        $subject = array_get($args, 'subject', '');
        $email = array_get($args, 'email', '');

        Mail::raw($msg, function ($message) use ($email, $subject) {
            $message->subject($subject);
            $message->to($email);
        });
    }
}
