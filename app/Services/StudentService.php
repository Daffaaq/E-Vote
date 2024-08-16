<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getStudentsWithStatusVote()
    {
        // to get all students
        return $this->studentRepository->getAllStudentsWithStatusVote();
    }

    public function createStudentAndUser($request)
    {
        $userData = [
            'username' => $request->nis,
            'name' => $request->nama,
            'password' => Hash::make($request->nis),
            'role' => 'voter',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // check if user username already exists
        if ($this->studentRepository->existsByUsername($request->nis)) {
            return ['error' => 'Usename sudah ada'];
        }
        $user = $this->studentRepository->createUser($userData);

        $studentData = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'users_id' => $user->id,
            'status_students' => $request->status_students,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // No need for manual check here
        return $this->studentRepository->createStudent($studentData);
    }


    public function updateStudentAndUser($request, $uuid)
    {
        // to find student by uuid
        $student = $this->studentRepository->findStudentByUUID($uuid);
        // to find user by id
        $user = $this->studentRepository->findUserById($student->users_id);

        $studentData = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_students' => $request->status_students,
            'updated_at' => now(),
        ];
        // check if student nis already exists
        if ($this->studentRepository->existsByNis($request->periode_nama)) {
            return ['error' => 'Nis sudah ada'];
        }

        $this->studentRepository->updateStudent($student, $studentData);

        $userData = [
            'username' => $request->nis,
            'name' => $request->nama,
            'password' => Hash::make($request->nis),
            'updated_at' => now(),
        ];

        // check if user username already exists
        $user = $this->studentRepository->findUserById($student->users_id);
        // dd($user);
        if (!$user) {
            return ['error' => 'siswa tidak ditemukan'];
        }

        return $this->studentRepository->updateUser($user, $userData);
    }

    public function deleteStudentAndUser($uuid)
    {
        // to find student by uuid
        $student = $this->studentRepository->findStudentByUUID($uuid);

        // to find user by id
        $user = $this->studentRepository->findUserByUsername($student->nis);

        $this->studentRepository->deleteStudent($student);

        if ($user) {
            $this->studentRepository->deleteUser($user);
        }
    }

    public function findStudentByUUID($uuid)
    {
        // to find student by uuid
        return $this->studentRepository->findStudentByUUID($uuid);
    }
}
