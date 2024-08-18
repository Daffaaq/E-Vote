<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    protected $model;

    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    public function getAll()
    {
        return $this->model->all();
    }
    public function getfirst()
    {
        return $this->model->first();
    }

    public function findByUuid($uuid)
    {
        return $this->model->where('uuid', $uuid)->firstOrFail();
    }


    public function updateByUuid($uuid, array $data)
    {
        $profile = $this->findByUuid($uuid);
        $profile->update($data);
        return $profile;
    }

}
