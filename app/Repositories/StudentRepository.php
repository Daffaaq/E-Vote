<?php

namespace App\Repositories;

use App\Models\Students;
use App\Models\User;

class StudentRepository
{
    public function getAllStudentsWithStatusVote()
    {
        return Students::with('StatusVote')->select('id', 'uuid', 'nama', 'nis', 'kelas', 'status_students')->get();
    }

    public function createUser($data)
    {
        return User::create($data);
    }

    public function createStudent($data)
    {
        return Students::create($data);
    }

    public function findStudentByUUID($uuid)
    {
        return Students::where('uuid', $uuid)->firstOrFail();
    }

    public function findStudentById($nis){
        return Students::where('nis', $nis)->firstOrFail();
    }

    public function findUserById($id)
    {
        return User::findOrFail($id);
    }

    public function findUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    public function existsByUsername($username)
    {
        return User::where('username', $username)->exists();
    }

    public function updateStudent($student, $data)
    {
        return $student->update($data);
    }

    public function updateUser($user, $data)
    {
        return $user->update($data);
    }

    public function deleteStudent($student)
    {
        return $student->delete();
    }

    public function deleteUser($user)
    {
        return $user->delete();
    }

    public function existsByNis($nis)
    {
        return Students::where('nis', $nis)->exists();
    }
}
