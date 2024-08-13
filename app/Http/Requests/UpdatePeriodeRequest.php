<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodeRequest extends FormRequest
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
            'periode_nama' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) {
                    [$startYear, $endYear] = explode('-', $value);
                    if ((int)$startYear >= (int)$endYear) {
                        $fail('Tahun pertama harus lebih kecil dari tahun kedua.');
                    }
                },
            ],
            'periode_kepala_sekolah' => 'required',
            'periode_no_kepala_sekolah' => 'required',
            'actif' => 'required|integer|in:1,2',
        ];
    }
    public function messages(): array
    {
        return [
            'periode_nama.required' => 'Nama periode wajib diisi.',
            'periode_nama.regex' => 'Format nama periode harus mengikuti format "YYYY-YYYY".',
            'periode_nama.function' => 'Tahun pertama harus lebih kecil dari tahun kedua.',
            'periode_kepala_sekolah.required' => 'Nama Kepala Institusi/Sekolah wajib diisi.',
            'periode_no_kepala_sekolah.required' => 'No Kepala Institusi/Sekolah wajib diisi.',
            'actif.required' => 'Status aktif harus dipilih.',
            'actif.in' => 'Status aktif harus Aktif atau Tidak aktif.',
        ];
    }
}
