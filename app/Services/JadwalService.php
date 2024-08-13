<?php

namespace App\Services;

use App\Models\Periode;
use App\Repositories\JadwalRepository;

class JadwalService
{
    protected $jadwalRepository;

    public function __construct(JadwalRepository $jadwalRepository)
    {
        $this->jadwalRepository = $jadwalRepository;
    }

    public function getJadwalForPeriode($periode_id)
    {
        return $this->jadwalRepository->getAllJadwalByPeriode($periode_id);
    }

    public function checkIfJadwalExists()
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        // dd($periode_id);
        $exists = $this->jadwalRepository->checkIfJadwalExists($periode_id);


        return $exists;
    }

    public function storeJadwal($validatedData, $periode_id)
    {
        $this->jadwalRepository->createJadwalOrasi([
            'periode_id' => $periode_id,
            'tanggal_orasi_vote' => $validatedData['tanggal_orasi_vote'],
            'jam_orasi_mulai' => $validatedData['jam_orasi_mulai'],
            'tempat_orasi' => $validatedData['tempat_orasi'],
        ]);

        $this->jadwalRepository->createJadwalVotes([
            'periode_id' => $periode_id,
            'tanggal_awal_vote' => $validatedData['tanggal_awal_vote'],
            'tanggal_akhir_vote' => $validatedData['tanggal_akhir_vote'],
            'tempat_vote' => $validatedData['tempat_vote'],
        ]);

        $this->jadwalRepository->createJadwalResultVote([
            'periode_id' => $periode_id,
            'tanggal_result_vote' => $validatedData['tanggal_result_vote'],
            'jam_result_vote' => $validatedData['jam_result_vote'],
            'tempat_result_vote' => $validatedData['tempat_result_vote'],
        ]);
    }

    public function getJadwalOrasiByUuid($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        return $this->jadwalRepository->getJadwalOrasiByUuid($uuid, $periode_id);
    }

    public function getJadwalVotesByUuid($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        return $this->jadwalRepository->getJadwalVotesByUuid($uuid, $periode_id);
    }

    public function getJadwalResultVoteByUuid($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        return $this->jadwalRepository->getJadwalResultVoteByUuid($uuid, $periode_id);
    }

    public function updateJadwalOrasi($uuid, $validatedData)
    {
        return $this->jadwalRepository->updateJadwalOrasi($uuid, $validatedData);
    }

    public function updateJadwalVotes($uuid, $validatedData)
    {
        return $this->jadwalRepository->updateJadwalVotes($uuid, $validatedData);
    }

    public function updateJadwalResultVote($uuid, $validatedData)
    {
        return $this->jadwalRepository->updateJadwalResultVote($uuid, $validatedData);
    }

    public function deleteJadwalOrasi($uuid)
    {
        return $this->jadwalRepository->deleteJadwalOrasi($uuid);
    }

    public function deleteJadwalVotes($uuid)
    {
        return $this->jadwalRepository->deleteJadwalVotes($uuid);
    }

    public function deleteJadwalResultVote($uuid)
    {
        return $this->jadwalRepository->deleteJadwalResultVote($uuid);
    }

    public function destroyAll($uuidOrasi, $uuidVotes, $uuidResult)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        return $this->jadwalRepository->destroyAll($uuidOrasi, $uuidVotes, $uuidResult, $periode_id);
    }
}
