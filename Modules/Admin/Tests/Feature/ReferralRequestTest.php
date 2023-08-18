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
        assertNotNull($referralRequest->user->referral_id);

        foreach (locale()->supported() as $locale) {
            assertNull($referralRequest["rejection_reason_$locale"]);
        }


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

        $rejectionReasons = [];

        foreach (locale()->supported() as $locale) {
            $rejectionReasons["rejection_reason_$locale"] = $this->faker->text;
        }

        $this
            ->postJson(route('admin.referral-request.reject', $referralRequest->id), $rejectionReasons)
            ->assertRedirect(route('admin.referral-request.index'));

        $this->assertDatabaseHas('referral_requests', [
            'id' => $referralRequest->id,
            'status' => ReferralRequestStatus::REJECTED,
            'user_id' => $referralRequest->user_id,
            'telegram_account' => $referralRequest->telegram_account,
            ...$rejectionReasons,
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

        $rejectionReasons = [];

        foreach (locale()->supported() as $locale) {
            $rejectionReasons["rejection_reason_$locale"] = $this->faker->realTextBetween(350, 500);
        }

        $this
            ->postJson(route('admin.referral-request.reject', $referralRequest->id), $rejectionReasons)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(array_keys($rejectionReasons));

        self::assertSame($referralRequest->status, ReferralRequestStatus::PENDING);
        assertNull($referralRequest->approved_at);
        assertNull($referralRequest->user->referral_id);
    }

    public function testItHasRequiredParametersOnRejection(): void
    {
        $referralRequest = ReferralRequestFactory::new()->create();

        $reasons = [];
        foreach (locale()->supported() as $locale) {
            $reasons[] = "rejection_reason_$locale";
        }

        $this
            ->postJson(route('admin.referral-request.reject', $referralRequest->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors($reasons);

        $referralRequest = $referralRequest->fresh();

        self::assertSame($referralRequest->status, ReferralRequestStatus::PENDING);
        assertNull($referralRequest->approved_at);
        assertNull($referralRequest->user->referral_id);
    }
}
