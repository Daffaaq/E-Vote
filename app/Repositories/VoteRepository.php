<?php

namespace App\Repositories;

use App\Models\Votes;

class VoteRepository
{
    protected $model;

    public function __construct(Votes $model)
    {
        $this->model = $model;
    }

    public function createVote(array $data)
    {
        return $this->model->create($data);
    }

    public function findVoteByStudentAndPeriode($studentId, $periodeId)
    {
        return $this->model->where('students_id', $studentId)
            ->where('periode_id', $periodeId)
            ->first();
    }
}
