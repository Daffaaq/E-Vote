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
        $periode = \App\Models\Periode::where('actif', 1)->first();
        if (!$periode) {
            throw new \Exception('No active periode found.');
        }

        $data['periode_id'] = $periode->id;

        // Check for sequential and unique no_urut_kandidat
        $lastNumber = $this->candidateRepository->getMaxNoUrut($periode->id);
        $expectedNumber = $lastNumber + 1;
        // dd($lastNumber);

        if ($data['no_urut_kandidat'] != $expectedNumber) {
            throw new \Exception("Nomor urut kandidat harus berurutan dan tidak boleh ada yang terlewat. Silakan masukkan nomor yang benar ($expectedNumber).");
        }

        if ($this->candidateRepository->existsByNoUrut($data['no_urut_kandidat'])) {
            throw new \Exception('Nomor urut kandidat sudah ada.');
        }

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

        $candidate = $this->candidateRepository->create($data);

        // Logging
        $logData = 'Created Candidate | Nama Ketua: ' . $candidate->nama_ketua .
            ($candidate->status === 'ganda' ? ' | Nama Wakil: ' . $candidate->nama_wakil_ketua : '') .
            ' | Slogan: ' . $candidate->slogan .
            ' | Periode: ' . $periode->periode_nama;

        $logEntry = [
            'action' => 'create',
            'url' => request()->url(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode->id,
            'user_id' => auth()->id(),
        ];

        \App\Models\Log::create($logEntry);

        return $candidate;
    }

    public function updateCandidate($uuid, array $data)
    {
        $candidate = $this->candidateRepository->findByUuid($uuid);

        if (!$candidate) {
            throw new \Exception('Candidate not found.');
        }

        $periode = $candidate->periode;

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
            $data['foto_wakil'] = $data['foto_wakil']->store('photos_wakil', 'public');
        }

        // Update candidate
        $updatedCandidate = $this->candidateRepository->update($candidate->id, $data);

        // Logging
        $logData = 'Updated Candidate | Nama Ketua: ' . $updatedCandidate->nama_ketua .
            ($updatedCandidate->status === 'ganda' ? ' | Nama Wakil: ' . $updatedCandidate->nama_wakil_ketua : '') .
            ' | Slogan: ' . $updatedCandidate->slogan .
            ' | Periode: ' . $periode->periode_nama;

        $logEntry = [
            'action' => 'update',
            'url' => request()->url(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode->id,
            'user_id' => auth()->id(),
        ];

        \App\Models\Log::create($logEntry);

        return $updatedCandidate;
    }
}
