<?php
// app/Services/UserService.php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersForDataTable()
    {
        return $this->userRepository->getUsersForDataTable();
    }

    public function getAllUsersExceptVoter()
    {
        return $this->userRepository->getAllUsersExceptVoter();
    }

    public function getUserByUuid($uuid)
    {
        return $this->userRepository->getUserByUuid($uuid);
    }

    public function createUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    public function updateUser($uuid, $data)
    {
        // Check if password is provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove the password field from the data array if it is not set or is empty
            unset($data['password']);
        }
        return $this->userRepository->updateUser($uuid, $data);
    }

    public function deleteUser($uuid)
    {
        return $this->userRepository->deleteUser($uuid);
    }
}
