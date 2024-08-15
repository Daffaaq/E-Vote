<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'status' => 'required|in:perseorangan,ganda',
            'nama_ketua' => 'nullable|string|max:255',
            'nama_wakil_ketua' => 'nullable|string|max:255',
            'slug' => 'nullable|string|unique:candidates,slug',
            'no_urut_kandidat' => 'required|numeric',
            'visi' => 'required',
            'misi' => 'required',
            'slogan' => 'required',
            'foto' => 'nullable|image',
            'periode_id' => 'nullable|exists:periode,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validated();

            // Check for sequential and unique no_urut_kandidat
            $lastNumber = \App\Models\Candidates::max('no_urut_kandidat');
            $expectedNumber = $lastNumber + 1;

            if ($data['no_urut_kandidat'] != $expectedNumber) {
                $validator->errors()->add('no_urut_kandidat', "Nomor urut kandidat harus berurutan dan tidak boleh ada yang terlewat. Silakan masukkan nomor yang benar ($expectedNumber).");
            }

            if (\App\Models\Candidates::where('no_urut_kandidat', $data['no_urut_kandidat'])->exists()) {
                $validator->errors()->add('no_urut_kandidat', 'Nomor urut kandidat sudah ada.');
            }

            // Validasi tambahan untuk nama_wakil_ketua berdasarkan status
            if ($data['status'] === 'perseorangan' && !empty($data['nama_wakil_ketua'])) {
                $validator->errors()->add('nama_wakil_ketua', 'Nama wakil ketua tidak diperlukan jika status adalah perseorangan.');
            }

            if ($data['status'] === 'ganda' && empty($data['nama_wakil_ketua'])) {
                $validator->errors()->add('nama_wakil_ketua', 'Nama wakil ketua diperlukan jika status adalah ganda.');
            }
        });
    }
}
