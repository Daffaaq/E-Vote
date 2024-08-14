<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nickname_profiles' => 'required|string',
            'name_profiles' => 'required|string',
            'address_profiles' => 'required|string',
            'phone_profiles' => 'required|string',
            'email_profiles' => 'required|string|email',
            'description_profiles' => 'nullable|string',
            'logo_profiles' => 'nullable|string',
            'twitter_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'line_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ];
    }
}
