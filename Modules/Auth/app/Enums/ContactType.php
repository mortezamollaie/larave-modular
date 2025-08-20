<?php

namespace Modules\Auth\Enums;

enum ContactType: string {
    case EMAIL = 'email';

    case PHONE = 'phone';

    public static function detectContactType(string $type): self{
        if(filter_var($type, FILTER_VALIDATE_EMAIL)){
            return self::EMAIL;
        }
        return self::PHONE;
    }
}
