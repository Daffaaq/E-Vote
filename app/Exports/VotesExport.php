<?php


namespace App\Exports;

use App\Models\Votes;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class VotesExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function view(): View
    // {
    //     // Ambil periode_id dari Periode yang aktif
    //     $periode_id = \App\Models\Periode::where('actif', 1)->value('id');

    //     // Ambil total suara
    //     $totalVotes = Votes::where('periode_id', $periode_id)->count();

    //     // Ambil status kandidat yang pertama ditemukan
    //     $statusCandidate = DB::table('candidates')
    //         ->join('votes', 'candidates.id', '=', 'votes.candidate_id')
    //         ->where('votes.periode_id', $periode_id)
    //         ->pluck('candidates.status')
    //         ->first();

    //     // Modifikasi query berdasarkan status
    //     if ($statusCandidate === 'perseorangan') {
    //         $candidate = DB::table("votes")
    //             ->join("candidates", "votes.candidate_id", "candidates.id")
    //             ->where('votes.periode_id', $periode_id)
    //             ->select(array(
    //                 "candidates.nama_ketua AS nama",
    //                 DB::raw("COUNT(votes.candidate_id) as jumlah_suara"),
    //                 DB::raw("ROUND((COUNT(votes.candidate_id) * 100 / $totalVotes), 2) as persentase")
    //             ))
    //             ->groupBy("votes.candidate_id", "candidates.nama_ketua")
    //             ->get();
    //         dd($candidate);
    //     } else if ($statusCandidate === 'ganda') {
    //         $candidate = DB::table("votes")
    //             ->join("candidates", "votes.candidate_id", "candidates.id")
    //             ->where('votes.periode_id', $periode_id)
    //             ->select(array(
    //                 "candidates.nama_ketua AS nama_ketua",
    //                 "candidates.nama_wakil_ketua AS nama_wakil",
    //                 DB::raw("COUNT(votes.candidate_id) as jumlah_suara"),
    //                 DB::raw("ROUND((COUNT(votes.candidate_id) * 100 / $totalVotes), 2) as persentase")
    //             ))
    //             ->groupBy("votes.candidate_id", "candidates.nama_ketua", "candidates.nama_wakil_ketua")
    //             ->get();
    //     } else {
    //         // Tangani kondisi lain jika ada
    //         $candidate = collect(); // Atau bisa ditangani sesuai kebutuhan
    //     }

    //     return view('exports.votes', [
    //         'candidate' => $candidate,
    //         'counting' => $totalVotes,
    //         'title' => 'Laporan Hasil Perhitungan Suara',
    //         'statusCandidate' => $statusCandidate // Kirim status kandidat ke view
    //     ]);
    // }
    public function view(): View
    {
        // Ambil periode_id dari Periode yang aktif
        $periode_id = \App\Models\Periode::where('actif', 1)->value('id');

        // Ambil total suara
        $totalVotes = Votes::where('periode_id', $periode_id)->count();

        // Ambil status kandidat yang pertama ditemukan
        $statusCandidate = DB::table('candidates')
            ->where('periode_id', $periode_id)
            ->pluck('status')
            ->first();

        // Modifikasi query berdasarkan status
        if ($statusCandidate === 'perseorangan') {
            $candidate = DB::table("candidates")
                ->leftJoin("votes", "votes.candidate_id", "=", "candidates.id")
                ->where('candidates.periode_id', $periode_id)
                ->select(array(
                    "candidates.nama_ketua AS nama",
                    DB::raw("COUNT(votes.candidate_id) as jumlah_suara"),
                    DB::raw("ROUND((COUNT(votes.candidate_id) * 100 / $totalVotes), 2) as persentase")
                ))
                ->groupBy("candidates.id", "candidates.nama_ketua")
                ->get()
                ->map(function ($item) {
                    // Set jumlah_suara dan persentase ke 0 jika null
                    $item->jumlah_suara = $item->jumlah_suara ?? 0;
                    $item->persentase = $item->persentase ?? 0;
                    return $item;
                });
        } else if ($statusCandidate === 'ganda') {
            $candidate = DB::table("candidates")
                ->leftJoin("votes", "votes.candidate_id", "=", "candidates.id")
                ->where('candidates.periode_id', $periode_id)
                ->select(array(
                    "candidates.nama_ketua AS nama_ketua",
                    "candidates.nama_wakil_ketua AS nama_wakil",
                    DB::raw("COUNT(votes.candidate_id) as jumlah_suara"),
                    DB::raw("ROUND((COUNT(votes.candidate_id) * 100 / $totalVotes), 2) as persentase")
                ))
                ->groupBy("candidates.id", "candidates.nama_ketua", "candidates.nama_wakil_ketua")
                ->get()
                ->map(function ($item) {
                    // Set jumlah_suara dan persentase ke 0 jika null
                    $item->jumlah_suara = $item->jumlah_suara ?? 0;
                    $item->persentase = $item->persentase ?? 0;
                    return $item;
                });
        } else {
            // Tangani kondisi lain jika ada
            $candidate = collect(); // Atau bisa ditangani sesuai kebutuhan
        }

        return view('exports.votes', [
            'candidate' => $candidate,
            'counting' => $totalVotes,
            'title' => 'Laporan Hasil Perhitungan Suara',
            'statusCandidate' => $statusCandidate // Kirim status kandidat ke view
        ]);
    }
}
