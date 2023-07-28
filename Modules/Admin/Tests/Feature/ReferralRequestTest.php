<?php

namespace Modules\Admin\Tests\Feature;

use App\Enums\ReferralRequestStatus;
use Illuminate\Support\Facades\Notification;
use Modules\Admin\Database\Factories\ReferralRequestFactory;
use Modules\Admin\Notifications\ReferralRequestNotification;
use Modules\Admin\Tests\AdminTestCase;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class ReferralRequestTest extends AdminTestCase
{
    public function testItApprovesSuccessfully(): void
    {
        Notification::fake();
        $referralRequest = ReferralRequestFactory::new()->create();

        $this
            ->postJson(route('admin.referral-request.approve', $referralRequest->id))
            ->assertRedirect(route('admin.referral-request.index'));

        $this->assertDatabaseHas('referral_requests', [
            'id' => $referralRequest->id,
            'status' => ReferralRequestStatus::APPROVED,
            'user_id' => $referralRequest->user_id,
            'telegram_account' => $referralRequest->telegram_account,
            'address' => $referralRequest->address,
            'document_photo' => $referralRequest->document_photo,
        ]);

        $referralRequest = $referralRequest->fresh();

        assertNotNull($referralRequest->approved_at);
        assertNull($referralRequest->rejection_reason);
        assertNotNull($referralRequest->user->referral_id);

        Notification::assertSentTo(
            $referralRequest->user,
            ReferralRequestNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels) && in_array('database', $channels);
            }
        );
    }

    public function testItRejectsSuccessfully(): void
    {
        Notification::fake();
        $referralRequest = ReferralRequestFactory::new()->create();

        $rejectionReason = $this->faker->text;

        $this
            ->postJson(route('admin.referral-request.reject', $referralRequest->id), [
                'rejection_reason' => $rejectionReason
            ])
            ->assertRedirect(route('admin.referral-request.index'));

        $this->assertDatabaseHas('referral_requests', [
            'id' => $referralRequest->id,
            'status' => ReferralRequestStatus::REJECTED,
            'user_id' => $referralRequest->user_id,
            'telegram_account' => $referralRequest->telegram_account,
            'rejection_reason' => $rejectionReason
        ]);

        $referralRequest = $referralRequest->fresh();

        assertNull($referralRequest->approved_at);
        assertNull($referralRequest->user->referral_id);

        Notification::assertSentTo(
            $referralRequest->user,
            ReferralRequestNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels) && in_array('database', $channels);
            }
        );
    }

    public function testItBadReasonParametersOnRejection(): void
    {
        $referralRequest = ReferralRequestFactory::new()->create();

        $this
            ->postJson(route('admin.referral-request.reject', $referralRequest->id), [
                'rejection_reason' => $this->faker->realTextBetween(350, 500)
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'rejection_reason'
            ]);

        self::assertSame($referralRequest->status, ReferralRequestStatus::PENDING);
        assertNull($referralRequest->approved_at);
        assertNull($referralRequest->user->referral_id);
    }

    public function testItHasRequiredParametersOnRejection(): void
    {
        $referralRequest = ReferralRequestFactory::new()->create();

        $this
            ->postJson(route('admin.referral-request.reject', $referralRequest->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'rejection_reason'
            ]);

        $referralRequest = $referralRequest->fresh();

        self::assertSame($referralRequest->status, ReferralRequestStatus::PENDING);
        assertNull($referralRequest->approved_at);
        assertNull($referralRequest->user->referral_id);
    }
}
