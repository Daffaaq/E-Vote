<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(AuthRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateProfile($user, $validatedData)
    {
        // Jika ada password, hash terlebih dahulu
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        // Perbarui data user
        $profile = $this->userRepository->updateUser($user, $validatedData);

        // Jika user adalah 'voter', perbarui juga tabel 'students'
        if ($user->role === 'voter') {
            $this->userRepository->updateStudent($user->id, $validatedData);
        }

        return $profile;
    }
}
