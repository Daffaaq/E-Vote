<?php

namespace App\Services;

use App\Models\Periode;
use App\Repositories\JadwalRepository;
use App\Repositories\LogRepository;

class JadwalService
{
    protected $jadwalRepository;
    protected $logRepository;

    public function __construct(JadwalRepository $jadwalRepository, LogRepository $logRepository)
    {
        $this->jadwalRepository = $jadwalRepository;
        $this->logRepository = $logRepository;
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

        // Log the creation action
        $logData = 'Tanggal Orasi: ' . $validatedData['tanggal_orasi_vote'] .
            ' | Jam Orasi Mulai: ' . $validatedData['jam_orasi_mulai'] .
            ' | Tempat Orasi: ' . $validatedData['tempat_orasi'] .
            ' | Tanggal Awal Vote: ' . $validatedData['tanggal_awal_vote'] .
            ' | Tanggal Akhir Vote: ' . $validatedData['tanggal_akhir_vote'] .
            ' | Tempat Vote: ' . $validatedData['tempat_vote'] .
            ' | Tanggal Result Vote: ' . $validatedData['tanggal_result_vote'] .
            ' | Jam Result Vote: ' . $validatedData['jam_result_vote'] .
            ' | Tempat Result Vote: ' . $validatedData['tempat_result_vote'];

        $logEntry = [
            'action' => 'create',
            'url' => url()->current(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode_id,
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);
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
        $result = $this->jadwalRepository->updateJadwalOrasi($uuid, $validatedData);

        // Log the update action
        $logData = 'Tanggal Orasi: ' . $validatedData['tanggal_orasi_vote'] .
            ' | Jam Orasi Mulai: ' . $validatedData['jam_orasi_mulai'] .
            ' | Tempat Orasi: ' . $validatedData['tempat_orasi'];

        $logEntry = [
            'action' => 'update',
            'url' => url()->current(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => Periode::where('actif', 1)->value('id'),
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }

    public function updateJadwalVotes($uuid, $validatedData)
    {
        $result = $this->jadwalRepository->updateJadwalVotes($uuid, $validatedData);

        // Log the update action
        $logData = 'Tanggal Awal Vote: ' . $validatedData['tanggal_awal_vote'] .
            ' | Tanggal Akhir Vote: ' . $validatedData['tanggal_akhir_vote'] .
            ' | Tempat Vote: ' . $validatedData['tempat_vote'];

        $logEntry = [
            'action' => 'update',
            'url' => url()->current(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => Periode::where('actif', 1)->value('id'),
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }

    public function updateJadwalResultVote($uuid, $validatedData)
    {
        $result = $this->jadwalRepository->updateJadwalResultVote($uuid, $validatedData);

        // Log the update action
        $logData = 'Tanggal Result Vote: ' . $validatedData['tanggal_result_vote'] .
            ' | Jam Result Vote: ' . $validatedData['jam_result_vote'] .
            ' | Tempat Result Vote: ' . $validatedData['tempat_result_vote'];

        $logEntry = [
            'action' => 'update',
            'url' => url()->current(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => Periode::where('actif', 1)->value('id'),
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }

    public function deleteJadwalOrasi($uuid)
    {
        $periode = Periode::where('actif', 1)->first();
        // Ambil data jadwal sebelum dihapus
        $jadwalOrasi = $this->jadwalRepository->getJadwalOrasiByUuid($uuid, Periode::where('actif', 1)->value('id'));

        if (!$jadwalOrasi) {
            return ['error' => 'Jadwal Orasi tidak ditemukan'];
        }

        // Hapus jadwal orasi
        $result = $this->jadwalRepository->deleteJadwalOrasi($uuid);
        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);
        // Log the deletion action with detailed data
        $logData = 'Deleted Jadwal Orasi | Tanggal Orasi: ' . $jadwalOrasi->tanggal_orasi_vote .
            ' | Jam Orasi Mulai: ' . $jadwalOrasi->jam_orasi_mulai .
            ' | Tempat Orasi: ' . $jadwalOrasi->tempat_orasi .
            ' | Periode: ' . $periode->periode_nama;

        $logEntry = [
            'action' => 'delete',
            'url' => $cleanedUrl,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => Periode::where('actif', 1)->value('id'),
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }

    public function deleteJadwalVotes($uuid)
    {
        $periode = Periode::where('actif', 1)->first();
        // Ambil data jadwal votes sebelum dihapus
        $jadwalVotes = $this->jadwalRepository->getJadwalVotesByUuid($uuid, Periode::where('actif', 1)->value('id'));

        if (!$jadwalVotes) {
            return ['error' => 'Jadwal Votes tidak ditemukan'];
        }

        // Hapus jadwal votes
        $result = $this->jadwalRepository->deleteJadwalVotes($uuid);
        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);
        // Log the deletion action with detailed data
        $logData = 'Deleted Jadwal Votes | Tanggal Awal Vote: ' . $jadwalVotes->tanggal_awal_vote .
            ' | Tanggal Akhir Vote: ' . $jadwalVotes->tanggal_akhir_vote .
            ' | Tempat Vote: ' . $jadwalVotes->tempat_vote .
            ' | Periode: ' . $periode->periode_nama;

        $logEntry = [
            'action' => 'delete',
            'url' => $cleanedUrl,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => Periode::where('actif', 1)->value('id'),
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }

    public function deleteJadwalResultVote($uuid)
    {
        $periode = Periode::where('actif', 1)->first();
        // Ambil data jadwal result vote sebelum dihapus
        $jadwalResultVote = $this->jadwalRepository->getJadwalResultVoteByUuid($uuid, Periode::where('actif', 1)->value('id'));

        if (!$jadwalResultVote) {
            return ['error' => 'Jadwal Result Vote tidak ditemukan'];
        }

        // Hapus jadwal result vote
        $result = $this->jadwalRepository->deleteJadwalResultVote($uuid);
        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);
        // Log the deletion action with detailed data
        $logData = 'Deleted Jadwal Result Vote | Tanggal Result Vote: ' . $jadwalResultVote->tanggal_result_vote .
            ' | Jam Result Vote: ' . $jadwalResultVote->jam_result_vote .
            ' | Tempat Result Vote: ' . $jadwalResultVote->tempat_result_vote .
            ' | Periode: ' . $periode->periode_nama;

        $logEntry = [
            'action' => 'delete',
            'url' => $cleanedUrl,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => Periode::where('actif', 1)->value('id'),
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }

    public function destroyAll($uuidOrasi, $uuidVotes, $uuidResult)
    {
        // Ambil periode yang aktif
        $periode = Periode::where('actif', 1)->first();

        if (!$periode) {
            return ['error' => 'Periode aktif tidak ditemukan'];
        }

        // Ambil data jadwal sebelum dihapus
        $jadwalOrasi = $this->jadwalRepository->getJadwalOrasiByUuid($uuidOrasi, $periode->id);
        $jadwalVotes = $this->jadwalRepository->getJadwalVotesByUuid($uuidVotes, $periode->id);
        $jadwalResultVote = $this->jadwalRepository->getJadwalResultVoteByUuid($uuidResult, $periode->id);

        // Hapus semua jadwal
        $result = $this->jadwalRepository->destroyAll($uuidOrasi, $uuidVotes, $uuidResult, $periode->id);

        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);
        // Log the deletion action with detailed data
        $logData = 'Deleted all Jadwal related to Periode: ' . $periode->periode_nama .
            ' | Orasi - Tanggal: ' . ($jadwalOrasi->tanggal_orasi_vote ?? 'N/A') .
            ' | Votes - Tanggal Awal: ' . ($jadwalVotes->tanggal_awal_vote ?? 'N/A') .
            ' | Votes - Tanggal Akhir: ' . ($jadwalVotes->tanggal_akhir_vote ?? 'N/A') .
            ' | Result Vote - Tanggal: ' . ($jadwalResultVote->tanggal_result_vote ?? 'N/A');

        $logEntry = [
            'action' => 'delete',
            'url' => $cleanedUrl,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode->id,
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return $result;
    }
}
