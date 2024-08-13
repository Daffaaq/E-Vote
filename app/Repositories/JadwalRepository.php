<?php

namespace App\Repositories;

use App\Models\jadwal_orasi;
use App\Models\JadwalVotes;
use App\Models\jadwal_result_vote;

class JadwalRepository
{
    public function getAllJadwalByPeriode($periode_id)
    {
        return [
            'jadwalOrasi' => jadwal_orasi::where('periode_id', $periode_id)->select("uuid", "tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->get(),
            'jadwalVotes' => JadwalVotes::where('periode_id', $periode_id)->select("uuid", "tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->get(),
            'jadwalResultVote' => jadwal_result_vote::where('periode_id', $periode_id)->select("uuid", "tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->get(),
        ];
    }

    public function createJadwalOrasi(array $data)
    {
        return jadwal_orasi::create($data);
    }

    public function createJadwalVotes(array $data)
    {
        return JadwalVotes::create($data);
    }

    public function createJadwalResultVote(array $data)
    {
        return jadwal_result_vote::create($data);
    }

    public function updateJadwalOrasi($uuid, array $data)
    {
        $jadwalOrasi = jadwal_orasi::where('uuid', $uuid)->firstOrFail();
        $jadwalOrasi->update($data);
        return $jadwalOrasi;
    }

    public function updateJadwalVotes($uuid, array $data)
    {
        $jadwalVotes = JadwalVotes::where('uuid', $uuid)->firstOrFail();
        $jadwalVotes->update($data);
        return $jadwalVotes;
    }

    public function updateJadwalResultVote($uuid, array $data)
    {
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuid)->firstOrFail();
        $jadwalResultVote->update($data);
        return $jadwalResultVote;
    }

    public function deleteJadwalOrasi($uuid)
    {
        $jadwalOrasi = jadwal_orasi::where('uuid', $uuid)->firstOrFail();
        return $jadwalOrasi->delete();
    }

    public function deleteJadwalVotes($uuid)
    {
        $jadwalVotes = JadwalVotes::where('uuid', $uuid)->firstOrFail();
        return $jadwalVotes->delete();
    }

    public function deleteJadwalResultVote($uuid)
    {
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuid)->firstOrFail();
        return $jadwalResultVote->delete();
    }

    public function checkIfJadwalExists($periode_id)
    {
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->first();
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->first();
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->first();

        // Mengembalikan true jika salah satu entitas ada
        return $jadwalOrasi !== null || $jadwalVotes !== null || $jadwalResultVote !== null;
    }



    public function destroyAll($uuidOrasi, $uuidVotes, $uuidResult, $periode_id)
    {
        $deletedCount = 0;

        // Menghapus Jadwal Orasi
        $jadwalOrasi = jadwal_orasi::where('uuid', $uuidOrasi)->where('periode_id', $periode_id)->first();
        if ($jadwalOrasi) {
            $deletedCount += $jadwalOrasi->delete();
        }

        // Menghapus Jadwal Votes
        $jadwalVotes = JadwalVotes::where('uuid', $uuidVotes)->where('periode_id', $periode_id)->first();
        if ($jadwalVotes) {
            $deletedCount += $jadwalVotes->delete();
        }

        // Menghapus Jadwal Result Vote
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuidResult)->where('periode_id', $periode_id)->first();
        if ($jadwalResultVote) {
            $deletedCount += $jadwalResultVote->delete();
        }

        return $deletedCount;
    }


    public function getJadwalOrasiByUuid($uuid, $periode_id)
    {
        return jadwal_orasi::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();
    }

    public function getJadwalVotesByUuid($uuid, $periode_id)
    {
        return JadwalVotes::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();
    }

    public function getJadwalResultVoteByUuid($uuid, $periode_id)
    {
        return jadwal_result_vote::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();
    }
}
