<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan dengan logika otorisasi Anda
    }

    public function rules()
    {
        return [
            'status' => 'required|in:perseorangan,ganda',
            'nama_ketua' => 'nullable|string|max:255',
            'nama_wakil_ketua' => 'nullable|string|max:255',
            'visi' => 'required',
            'misi' => 'required',
            'slogan' => 'required',
            'foto' => 'nullable|image',
            'foto_wakil' => 'nullable|image',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validated();

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
