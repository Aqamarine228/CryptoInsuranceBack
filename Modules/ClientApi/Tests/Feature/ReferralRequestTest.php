<?php

namespace Modules\ClientApi\Tests\Feature;

use App\Enums\ReferralRequestStatus;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\ClientApi\Database\Factories\ReferralRequestFactory;
use Modules\ClientApi\Models\ReferralRequest;
use Modules\ClientApi\Models\User;
use Modules\ClientApi\Tests\ClientApiTestCase;

class ReferralRequestTest extends ClientApiTestCase
{

    /**
     * @throws \Exception
     */
    public function testItCreatesSuccessfully(): void
    {
        $this->postJson('/api/v1/referral-request', [
            'telegram_account' => 'goodTelegram',
            'document_photo' => File::image('image.jpeg'),
            'address' => 'good street',
        ])->assertOk();

        $this->assertDatabaseHas('referral_requests', [
            'user_id' => $this->user->id,
            'status' => ReferralRequestStatus::PENDING->value,
            'telegram_account' => 'goodTelegram',
            'approved_at' => null,
            'address' => 'good street',
        ]);

        self::assertTrue(
            Storage::disk('private')
                ->exists(ReferralRequest::getDocumentPath($this->user->referralRequests()->first()->document_photo))
        );
    }

    public function testReferralRequestAlreadyExists(): void
    {
        ReferralRequestFactory::new()->state([
            'user_id' => $this->user->id,
        ])->create();

        $this->postJson('/api/v1/referral-request', [
            'telegram_account' => 'goodTelegram',
            'address' => 'good street',
            'document_photo' => File::image('image.jpeg'),
        ])->assertBadRequest();
    }

    public function testUserAlreadyReferral(): void
    {
        User::unguarded(function () {
            $this->user->update(['referral_id' => Str::uuid()]);
        });

        $this->postJson('/api/v1/referral-request', [
            'telegram_account' => 'goodTelegram',
            'document_photo' => File::image('image.jpeg'),
            'address' => 'good street',
        ])->assertBadRequest();
    }

    public function testUnprocessableContent(): void
    {
        $this->postJson('/api/v1/referral-request', [
            'telegram_account' => $this->faker->realTextBetween(350, 400),
            'address' => $this->faker->realTextBetween(350, 400),
            'document_photo' => 'hello',
        ])->assertUnprocessable()->assertInvalid(['telegram_account', 'document_photo', 'address']);
    }
}
