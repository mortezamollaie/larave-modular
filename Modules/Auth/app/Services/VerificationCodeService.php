<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Auth\Enums\ContactType;
use Modules\Auth\Enums\VerificationActionType;

class VerificationCodeService
{
    public function getCacheKey($contact, VerificationActionType $action, ContactType $contactType)
    {
        return "verification:{$action->value}:{$contactType->value}:{$contact}";
    }

    public function generateCode(string $contact, VerificationActionType $action, ContactType $contactType, ?int $expiryMinutes = null)
    {
        if($expiryMinutes === null){
            $expiryMinutes = $contactType === ContactType::EMAIL ? 5 : 1;
        }

        $code = random_int(100000, 999999);

        $cacheKy = $this->getCacheKey($contact, $action, $contactType);

        $expiredAt = now()->addMinutes($expiryMinutes);

        Cache::put($cacheKy, [
            'code' => $code,
            'expires_at' => $expiredAt
        ], $expiredAt);

        return $code;
    }

    public function handle() {}
}
