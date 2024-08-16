<?php

namespace App\Repositories;

use App\Models\Aspirasi;
use App\Models\Students;

class AspirasiRepository
{
    protected $model;

    public function __construct(Aspirasi $aspirasi)
    {
        $this->model = $aspirasi;
    }

    public function getAllAspirasi()
    {
        return Aspirasi::select('id', 'uuid', 'nama', 'nis', 'kelas', 'description_profiles')->get();
    }

    public function findByNis(string $nis)
    {
        return Students::where('nis', $nis)->first();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function findByUuid($uuid)
    {
        return $this->model->where('uuid', $uuid)->firstOrFail();
    }


    public function delete($uuid)
    {
        $aspirasi = $this->model->where('uuid', $uuid)->firstOrFail();
        return $aspirasi->delete();
    }
}
