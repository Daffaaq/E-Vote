<?php

namespace App\Http\Controllers;

use App\Models\JadwalVotes;
use App\Models\Periode;
use App\Models\SettingVote;
use App\Services\VoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VotingController extends Controller
{
    protected $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function vote(Request $request)
    {
        $user = Auth::user();

        $statusSetVote = SettingVote::where('set_vote', 1)->first();
        if (!$statusSetVote) {
            return redirect()->back()->withErrors('Mohon maaf, voting telah ditutup oleh admin.')->withInput();
        }

        $periode_id = Periode::where('actif', 1)->value('id');

        $jadwalVote = JadwalVotes::where('periode_id', $periode_id)
            ->whereDate('tanggal_awal_vote', '<=', now())
            ->whereDate('tanggal_akhir_vote', '>=', now())
            ->first();

        if (!$jadwalVote) {
            return redirect()->back()->withErrors('Mohon maaf, tidak ada jadwal voting')->withInput();
        }

        $data = [
            'periode_id' => $periode_id,
            'students_id' => $user->student->id,
            'candidate_id' => $request->input('candidate_id'),
            'tanggal_vote' => now(),
            'jam_vote' => now(),
            'jadwal_votes_id' => $jadwalVote->id,
            'created_by' => $user->id,
        ];
        // dd($data);
        try {
            $vote = $this->voteService->castVote($data);

            return redirect()->route('vote.success')->with('success', 'Your vote has been cast successfully.');
        } catch (\Exception $e) {
            Log::error('Voting error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
