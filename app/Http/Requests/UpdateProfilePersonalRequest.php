<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePersonalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nickname_profiles' => 'sometimes|string',
            'name_profiles' => 'sometimes|string',
            'address_profiles' => 'sometimes|string',
            'phone_profiles' => 'sometimes|string',
            'email_profiles' => 'sometimes|string|email',
            'description_profiles' => 'nullable|string',
        ];
    }
}
