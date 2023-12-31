<?php

namespace Modules\ClientApi\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        return $this->buildMailMessage($notifiable->locale, $verificationUrl);
    }

    protected function buildMailMessage($locale, $url): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.verifyEmail.pageTitle'))
            ->view("emails.verification", ['url' => $url, 'locale' => $locale]);
    }

    protected function verificationUrl($notifiable): string
    {
        $backendUrl = URL::temporarySignedRoute(
            'api.v1.email.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
        return config('frontend.verify_email_link') . '?verification_link=' . urlencode($backendUrl);
    }
}
