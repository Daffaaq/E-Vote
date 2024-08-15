<?php

namespace App\Services;

use App\Repositories\VoteRepository;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    protected $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }

    public function castVote(array $data)
    {
        $existingVote = $this->voteRepository->findVoteByStudentAndPeriode(
            $data['students_id'],
            $data['periode_id']
        );

        if ($existingVote) {
            throw new \Exception('You have already voted in this period.');
        }

        $vote = $this->voteRepository->createVote($data);

        return $vote;
    }
}
