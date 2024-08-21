<?php

namespace App\Services;

use App\Repositories\CandidateRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CandidateService
{
    protected $candidateRepository;

    public function __construct(CandidateRepository $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function createCandidate(array $data)
    {
        // Ambil periode_id dari Periode yang aktif
        $periode_id = \App\Models\Periode::where('actif', 1)->value('id');
        // dd($periode_id);
        $data['periode_id'] = $periode_id;

        // Check for sequential and unique no_urut_kandidat
        $lastNumber = $this->candidateRepository->getMaxNoUrut($periode_id);
        $expectedNumber = $lastNumber + 1;
        // dd($lastNumber);

        if ($data['no_urut_kandidat'] != $expectedNumber) {
            throw new \Exception("Nomor urut kandidat harus berurutan dan tidak boleh ada yang terlewat. Silakan masukkan nomor yang benar ($expectedNumber).");
        }

        if ($this->candidateRepository->existsByNoUrut($data['no_urut_kandidat'])) {
            throw new \Exception('Nomor urut kandidat sudah ada.');
        }

        // // Jika statusnya 'perseorangan', pastikan nama_wakil_ketua tidak diisi
        // if ($data['status'] === 'perseorangan' && !empty($data['nama_wakil_ketua'])) {
        //     throw new \Exception('Nama wakil ketua tidak diperlukan jika status adalah perseorangan.');
        // }

        // // Jika statusnya 'ganda', pastikan nama_wakil_ketua diisi
        // if ($data['status'] === 'ganda' && empty($data['nama_wakil_ketua'])) {
        //     throw new \Exception('Nama wakil ketua diperlukan jika status adalah ganda.');
        // }

        // Buat slug secara otomatis jika tidak disediakan
        if (empty($data['slug'])) {
            $baseSlug = $data['status'] === 'perseorangan'
                ? Str::slug($data['nama_ketua'], '-')
                : Str::slug($data['nama_ketua'] . '-' . $data['nama_wakil_ketua'], '-');

            $slug = $baseSlug;

            while ($this->candidateRepository->existsBySlug($slug)) {
                $slug = $baseSlug . '-' . Str::random(6);
            }

            $data['slug'] = $slug;
        }

        // Handle the photo upload
        if (isset($data['foto'])) {
            $data['foto'] = $data['foto']->store('photos', 'public');
        }
        if ($data['status'] === 'ganda') {
            if (isset($data['foto_wakil'])) {
                $data['foto_wakil'] = $data['foto_wakil']->store('photos_wakil', 'public');
            }
        }

        // dd($data);

        return $this->candidateRepository->create($data);
    }

    public function updateCandidate($uuid, array $data)
    {
        $candidate = $this->candidateRepository->findByUuid($uuid);

        if (!$candidate) {
            throw new \Exception('Candidate not found.');
        }

        // Handle the photo upload
        if (isset($data['foto'])) {
            if ($candidate->foto) {
                Storage::disk('public')->delete($candidate->foto);
            }
            $data['foto'] = $data['foto']->store('photos', 'public');
        }

        if (isset($data['foto_wakil'])) {
            if ($candidate->foto_wakil) {
                Storage::disk('public')->delete($candidate->foto_wakil);
            }
            $data['foto_wakil'] = $data['foto_wakil']->store('photos', 'public');
        }

        return $this->candidateRepository->update($candidate->id, $data);
    }
}
