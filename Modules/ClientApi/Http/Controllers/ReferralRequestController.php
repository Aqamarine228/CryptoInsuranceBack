<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Actions\GenerateFileName;
use App\Enums\ReferralRequestStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\ClientApi\Models\ReferralRequest;

class ReferralRequestController extends BaseClientApiController
{

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'telegram_account' => 'required|string|max:255',
            'document_photo' => 'required|image|mimetypes:image/jpeg,image/png,image/jpg',
            'address' => 'required|string|max:255',
        ]);

        if ($request->user()->referral_id) {
            return $this->respondErrorMessage('User is already a referral.');
        }

        if ($request->user()->referralRequests()->where('status', ReferralRequestStatus::PENDING)->exists()) {
            return $this->respondErrorMessage('Pending referral request already exists.');
        }

        DB::transaction(static function () use ($request, $validated) {
            $documentPhoto = $request->file('document_photo');
            $documentPhotoFileName = GenerateFileName::execute($documentPhoto->extension());
            Storage::disk('private')
                ->put(ReferralRequest::getDocumentPath($documentPhotoFileName), $documentPhoto->getContent());

            $request->user()->referralRequests()->create([
                'approved_at' => null,
                'telegram_account' => $validated['telegram_account'],
                'document_photo' => $documentPhotoFileName,
                'address' => $validated['address'],
            ]);
        });

        return $this->respondSuccess('Referral request created successfully.');
    }
}
