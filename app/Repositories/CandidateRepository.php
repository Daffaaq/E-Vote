<?php

namespace App\Repositories;

use App\Models\Candidates;

class CandidateRepository
{
    protected $model;

    public function __construct(Candidates $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByUuid($uuid)
    {
        return $this->model->where('uuid', $uuid)->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $candidate = $this->model->find($id);
        if ($candidate) {
            $candidate->update($data);
            return $candidate;
        }

        return null;
    }

    public function delete($id)
    {
        $candidate = $this->model->find($id);
        if ($candidate) {
            return $candidate->delete();
        }

        return false;
    }

    public function getMaxNoUrut()
    {
        return $this->model->max('no_urut_kandidat');
    }

    public function existsByNoUrut($noUrut)
    {
        return $this->model->where('no_urut_kandidat', $noUrut)->exists();
    }

    public function existsBySlug($slug)
    {
        return $this->model->where('slug', $slug)->exists();
    }
}
