<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Students;

class AuthRepository
{
    public function findUserById($id)
    {
        return User::find($id);
    }

    public function updateUser($user, $data)
    {
        if (isset($data['password'])) {
            $user->password = $data['password'];
        }
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->save();

        return $user;
    }

    public function updateStudent($userId, $data)
    {
        $student = Students::where('users_id', $userId)->first();

        if ($student) {
            $student->nama = $data['nama'];
            $student->nis = $data['nis'];
            $student->jenis_kelamin = $data['jenis_kelamin'];
            $student->save();
        }

        return $student;
    }
}
