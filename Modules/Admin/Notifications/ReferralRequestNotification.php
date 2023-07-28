<?php

namespace Modules\Admin\Notifications;

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
        return (new MailMessage)
            ->view('emails.referral-request', [
                'status' => $this->referralRequest->status,
                'reason' => $this->referralRequest->rejection_reason
            ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'status' => $this->referralRequest->status->value,
            'rejection_reason' => $this->referralRequest->rejection_reason
        ];
    }
}
