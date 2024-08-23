<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        // Check if the request method is POST (for store) or PUT/PATCH (for update)
        $passwordRule = $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8';
        $usernameRule = $this->isMethod('post') ? 'required|string|max:255|unique:users,username,' . $this->route('id') : 'nullable|string|max:255';

        return [
            'name' => 'required|string|max:255',
            'username' => $usernameRule,
            'password' => $passwordRule,
            'role' => 'required|in:superadmin,admin',
            'foto_profile' => 'nullable|string|max:255',
        ];
    }
}
