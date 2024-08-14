<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nickname_profiles' => 'sometimes|string',
            'name_profiles' => 'sometimes|string',
            'address_profiles' => 'sometimes|string',
            'phone_profiles' => 'sometimes|string',
            'email_profiles' => 'sometimes|string|email',
            'description_profiles' => 'nullable|string',
            'logo_profiles' => 'nullable|string',
            'twitter_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'line_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'threads_url' => 'nullable|url',
        ];
    }
}
