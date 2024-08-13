<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $uuid = $this->route('uuid');

        return [
            'nama' => 'required|string',
            'name' => 'required|string',
            'nis' => 'required|string|unique:students,nis,' . $uuid . ',uuid',
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'status_students' => 'required|integer|in:1,2',
        ];
    }

    public function messages()
    {
        return [
            'nis.unique' => 'NIS sudah ada, silakan gunakan NIS yang berbeda.',
            'nis.required' => 'NIS harus diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin harus dipilih Laki-Laki/Perempuan.',
            'status_students.in' => 'Status mahasiswa harus dipilih Aktif/NonAktif.',
            'status_students.required' => 'Status mahasiswa harus dipilih.',
            'kelas.required' => 'Kelas harus dipilih.',
            'nama.required' => 'Nama Lengkap harus diisi.',
            'name.required' => 'Nama Panggilan harus diisi.',
        ];
    }
}
