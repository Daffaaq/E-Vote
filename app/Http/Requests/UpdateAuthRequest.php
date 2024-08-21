<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthRequest extends FormRequest
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
        $user = $this->user(); // Ambil user yang sedang login

        if ($user->role === 'voter') {
            return [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'password' => 'nullable|string|min:8',
                'nama' => 'required|string|max:255',
                'nis' => 'required|string|max:255',
                'jenis_kelamin' => 'sometimes|nullable|string|max:10',
            ];
        } else {
            return [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'password' => 'nullable|string|min:8',
            ];
        }
    }
}
