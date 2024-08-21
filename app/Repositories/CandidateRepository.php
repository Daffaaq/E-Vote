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

    public function where($column, $value)
    {
        return $this->model->where($column, $value);
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

    public function getMaxNoUrut($periode_id)
    {
        return $this->model->where('periode_id', $periode_id)->max('no_urut_kandidat') ?? 0;
    }


    public function existsByNoUrut($noUrut)
    {
        $periode_id = \App\Models\Periode::where('actif', 1)->value('id');
        return $this->model->where('no_urut_kandidat', $noUrut)->where('periode_id', $periode_id)->exists();
    }

    public function existsBySlug($slug)
    {
        return $this->model->where('slug', $slug)->exists();
    }
}
