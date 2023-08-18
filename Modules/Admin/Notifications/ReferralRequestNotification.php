<?php

namespace Modules\Admin\Notifications;

use App;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Admin\Models\ReferralRequest;

class ReferralRequestNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly ReferralRequest $referralRequest)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = $notifiable->locale;
        return (new MailMessage)
            ->view("emails.$locale.referral-request", [
                'status' => $this->referralRequest->status,
                'reason' => $this->referralRequest["rejection_reason_$locale"]
            ]);
    }

    public function toArray($notifiable): array
    {
        $reasons = [];
        foreach (locale()->supported() as $locale) {
            $reasons["rejection_reason_$locale"] = $this->referralRequest["rejection_reason_$locale"];
        }
        return [
            'status' => $this->referralRequest->status->value,
            ...$reasons,
        ];
    }
}
