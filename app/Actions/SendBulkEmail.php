<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Mailgun\Mailgun;

class SendBulkEmail
{
    /**
     * Send the bulk email using the Mailgun API.
     */
    public function execute(Notification $notification, string $subject, array $recipients): void
    {
        $mailgun = Mailgun::create(config('services.mailgun.secret'));

        // We create a batch message, and set the sender, subject and HTML body
        $email = $mailgun->messages()
            ->getBatchMessage(config('services.mailgun.domain'))
            ->setFromAddress(config('mail.from.address'))
            ->setSubject($subject)
            ->setHtmlBody($notification->toMail()->render());

        // We add the recipient's email, and pass the recipient's data to the view
        foreach ($recipients as $recipient) {
            $email->addToRecipient($recipient['email'], $recipient['data']);
        }

        $email->finalize();
    }
}
