<?php

namespace App\Services;

use App\Repositories\ProfileRepository;

class ProfileService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAllProfiles()
    {
        return $this->profileRepository->getAll();
    }


    public function getProfileByUuid($uuid)
    {
        return $this->profileRepository->findByUuid($uuid);
    }

    public function updateProfile($uuid, array $data)
    {
        return $this->profileRepository->updateByUuid($uuid, $data);
    }

}
