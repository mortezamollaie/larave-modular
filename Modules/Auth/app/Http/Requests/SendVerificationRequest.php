<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\Auth\Enums\ContactType;
use Modules\Auth\Enums\VerificationActionType;

class SendVerificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'action' => [
                'required',
                'string',
                new Enum(VerificationActionType::class)
            ],
            'contact' => [
                'required',
                'string',
                ...$this->getContactValidationRules(),
            ]
        ];
    }

    private function getContactValidationRules(): array
    {
        $contactType = ContactType::detectContactType(($this->input('contact', '')));

        $verificationAction = VerificationActionType::tryFrom($this->input('action'));

        if(!$verificationAction){
            return [];
        }

        if($contactType === ContactType::EMAIL) {
            return [
                'email:rfc,dns',
                Rule::when($verificationAction->isContactNeedToBeUnique(), [
                    'unique:users,email'
                ]),
                Rule::when($verificationAction->isContactNeedToBeExist(), [
                    'exists:users,email'
                ])
            ];
        }

        return [
            'phone:mobile',
            Rule::when($verificationAction->isContactNeedToBeUnique(), [
                'unique:users,phone'
            ]),
            Rule::when($verificationAction->isContactNeedToBeExist(), [
                'exists:users,phone'
            ])
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
