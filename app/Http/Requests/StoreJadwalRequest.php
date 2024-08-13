<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalRequest extends FormRequest
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
            'tanggal_orasi_vote' => 'required|date',
            'jam_orasi_mulai' => 'required|date_format:H:i',
            'tempat_orasi' => 'required|string|max:255',

            'tanggal_awal_vote' => 'required|date',
            'tanggal_akhir_vote' => 'required|date|after_or_equal:tanggal_awal_vote',
            'tempat_vote' => 'required|string|max:255',

            'tanggal_result_vote' => 'required|date',
            'jam_result_vote' => 'required|date_format:H:i',
            'tempat_result_vote' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_orasi_vote.required' => 'Tanggal orasi vote wajib diisi.',
            'jam_orasi_mulai.required' => 'Jam orasi mulai wajib diisi.',
            'tempat_orasi.required' => 'Tempat orasi wajib diisi.',

            'tanggal_awal_vote.required' => 'Tanggal awal vote wajib diisi.',
            'tanggal_akhir_vote.required' => 'Tanggal akhir vote wajib diisi.',
            'tanggal_akhir_vote.after_or_equal' => 'Tanggal akhir vote harus sama dengan atau setelah tanggal awal vote.',
            'tempat_vote.required' => 'Tempat vote wajib diisi.',

            'tanggal_result_vote.required' => 'Tanggal hasil vote wajib diisi.',
            'jam_result_vote.required' => 'Jam hasil vote wajib diisi.',
            'tempat_result_vote.required' => 'Tempat hasil vote wajib diisi.',
        ];
    }
}
