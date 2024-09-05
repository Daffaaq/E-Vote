<?php

namespace App\Repositories;

use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;

class StudentRepository
{
    public function getAllStudentsWithStatusVote()
    {
        return Students::with(['StatusVote' => function ($query) {
            $query->activePeriod();
        }])->select('id', 'uuid', 'nama', 'nis', 'kelas', 'status_students')->get();
    }

    public function getAllStudentsWithStatusVoteFilter(Request $request)
    {
        $statusVote = $request->input('status_vote');
        $statusAccount = $request->input('status_account');

        $query = Students::with(['StatusVote' => function ($query) {
            $query->whereHas('periode', function ($query) {
                $query->where('actif', 1);
            });
        }])->select('id', 'uuid', 'nama', 'nis', 'kelas', 'status_students');

        if ($statusVote === '1') {
            $query->whereHas('StatusVote', function ($q) {
                $q->whereHas('periode', function ($q) {
                    $q->where('actif', 1);
                });
            });
        } elseif ($statusVote === '0') {
            $query->whereDoesntHave('StatusVote', function ($q) {
                $q->whereHas('periode', function ($q) {
                    $q->where('actif', 1);
                });
            });
        }

        if ($statusAccount) {
            $query->where('status_students', $statusAccount);
        }

        return $query->get();
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

    public function findStudentById($nis)
    {
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
