<?php

namespace Modules\Admin\Tests\Feature;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Support\Facades\Notification;
use Modules\Admin\Database\Factories\InsuranceRequestFactory;
use Modules\Admin\Notifications\InsuranceRequestNotification;
use Modules\Admin\Tests\AdminTestCase;
use function PHPUnit\Framework\assertNull;

class InsuranceRequestTest extends AdminTestCase
{
    public function testItApprovesSuccessfully(): void
    {
        Notification::fake();
        $insuranceRequest = InsuranceRequestFactory::new()->create();

        $this
            ->postJson(route('admin.insurance-request.approve', $insuranceRequest->id))
            ->assertRedirect(route('admin.insurance-request.index'));

        $this->assertDatabaseHas('insurance_requests', [
            'id' => $insuranceRequest->id,
            'status' => InsuranceRequestStatus::APPROVED,
            'user_id' => $insuranceRequest->user_id,
        ]);

        $insuranceRequest = $insuranceRequest->fresh();
        self::assertNotNull($insuranceRequest->approved_at);

        foreach (locale()->supported() as $locale) {
            assertNull($insuranceRequest["rejection_reason_$locale"]);
        }

        Notification::assertSentTo(
            $insuranceRequest->user,
            InsuranceRequestNotification::class,
            function ($notification, $channels) {
                return in_array('database', $channels);
            }
        );
    }

    public function testItRejectsSuccessfully(): void
    {
        Notification::fake();
        $insuranceRequest = InsuranceRequestFactory::new()->create();

        $rejectionReasons = [];

        foreach (locale()->supported() as $locale) {
            $rejectionReasons["rejection_reason_$locale"] = $this->faker->text;
        }

        $this
            ->postJson(route('admin.insurance-request.reject', $insuranceRequest->id), $rejectionReasons)
            ->assertRedirect(route('admin.insurance-request.index'));

        $this->assertDatabaseHas('insurance_requests', [
            'id' => $insuranceRequest->id,
            'status' => InsuranceRequestStatus::REJECTED,
            'user_id' => $insuranceRequest->user_id,
            ...$rejectionReasons,
        ]);

        $insuranceRequest = $insuranceRequest->fresh();

        assertNull($insuranceRequest->approved_at);

        Notification::assertSentTo(
            $insuranceRequest->user,
            InsuranceRequestNotification::class,
            function ($notification, $channels) {
                return in_array('database', $channels);
            }
        );
    }

    public function testItBadReasonParametersOnRejection(): void
    {
        $insuranceRequest = InsuranceRequestFactory::new()->create();

        $rejectionReasons = [];

        foreach (locale()->supported() as $locale) {
            $rejectionReasons["rejection_reason_$locale"] = $this->faker->realTextBetween(350, 500);
        }

        $this
            ->postJson(route('admin.insurance-request.reject', $insuranceRequest->id), $rejectionReasons)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(array_keys($rejectionReasons));

        self::assertSame($insuranceRequest->status, InsuranceRequestStatus::PENDING);
        assertNull($insuranceRequest->approved_at);
    }

    public function testItHasRequiredParametersOnRejection(): void
    {
        $insuranceRequest = InsuranceRequestFactory::new()->create();

        $reasons = [];
        foreach (locale()->supported() as $locale) {
            $reasons[] = "rejection_reason_$locale";
        }

        $this
            ->postJson(route('admin.insurance-request.reject', $insuranceRequest->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors($reasons);

        $insuranceRequest = $insuranceRequest->fresh();

        self::assertSame($insuranceRequest->status, InsuranceRequestStatus::PENDING);
        assertNull($insuranceRequest->approved_at);
        assertNull($insuranceRequest->user->referral_id);
    }
}
