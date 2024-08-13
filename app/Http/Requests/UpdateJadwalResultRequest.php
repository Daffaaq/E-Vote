<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalResultRequest extends FormRequest
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
            'tanggal_result_vote' => 'required|date',
            'jam_result_vote' => 'required',
            'tempat_result_vote' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'tempat_result_vote.required' => 'Tempat result vote wajib diisi.',
            'jam_result_vote.required' => 'Waktu result vote wajib diisi.',
            'tanggal_result_vote.required' => 'Tanggal result vote wajib diisi.',
        ];
    }
}
