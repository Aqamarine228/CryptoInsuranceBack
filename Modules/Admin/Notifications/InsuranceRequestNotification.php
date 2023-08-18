<?php

namespace Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Admin\Models\InsuranceRequest;

class InsuranceRequestNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly InsuranceRequest $insuranceRequest)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $reasons = [];
        foreach (locale()->supported() as $locale) {
            $reasons["rejection_reason_$locale"] = $this->insuranceRequest["rejection_reason_$locale"];
        }
        return [
            'status' => $this->insuranceRequest->status->value,
            ...$reasons,
        ];
    }
}
