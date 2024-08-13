<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalVoteRequest extends FormRequest
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
            'tanggal_awal_vote' => 'required|date',
            'tanggal_akhir_vote' => 'required|date|after_or_equal:tanggal_awal_vote',
            'tempat_vote' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'tanggal_awal_vote.required' => 'Waktu awal vote wajib diisi.',
            'tanggal_akhir_vote.required' => 'Waktu akhir vote wajib diisi.',
            'tanggal_akhir_vote.after_or_equal' => 'Waktu akhir vote harus sama dengan atau setelah waktu awal vote.',
            'tempat_vote.required' => 'Tempat vote wajib diisi.',
        ];
    }
}
