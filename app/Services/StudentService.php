<?php

namespace App\Services;

use App\Models\Periode;
use App\Repositories\StudentRepository;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    protected $studentRepository;
    protected $logRepository;

    public function __construct(StudentRepository $studentRepository, LogRepository $logRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->logRepository = $logRepository;
    }

    public function getStudentsWithStatusVote()
    {
        // to get all students
        return $this->studentRepository->getAllStudentsWithStatusVote();
    }

    public function getStudentsWithStatusVoteFilter(Request $request)
    {
        return $this->studentRepository->getAllStudentsWithStatusVoteFilter($request);
    }


    public function createStudentAndUser($request)
    {
        $userData = [
            'username' => $request->nis,
            'name' => $request->name,
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
        $student = $this->studentRepository->createStudent($studentData);
        $periode_id = Periode::where('actif', 1)->value('id');
        
        // Prepare log data with all relevant fields
        $logData = 'Nama: ' . $studentData['nama'] .
            ' | Nis: ' . $studentData['nis'] .
            ' | Kelas: ' . $studentData['kelas'] .
            ' | Jenis Kelamin: ' . $studentData['jenis_kelamin'] .
            ' | Status: ' . $studentData['status_students'];

        // Log the creation action
        $logEntry = [
            'action' => 'create',
            'url' => url()->current(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode_id, // Example period ID, you can adjust this
            'user_id' => auth()->id(), // Get the logged-in user's ID
        ];

        $this->logRepository->create($logEntry);

        return $student;
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
            'name' => $request->name,
            'password' => Hash::make($request->nis),
            'updated_at' => now(),
        ];

        // check if user username already exists
        $user = $this->studentRepository->findUserById($student->users_id);
        // dd($user);
        if (!$user) {
            return ['error' => 'siswa tidak ditemukan'];
        }

        $this->studentRepository->updateUser($user, $userData);

        $periode_id = Periode::where('actif', 1)->value('id');

        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);
        // Prepare log data with all relevant fields
        $logData = 'Nama: ' . $studentData['nama'] .
            ' | Nis: ' . $studentData['nis'] .
            ' | Kelas: ' . $studentData['kelas'] .
            ' | Jenis Kelamin: ' . $studentData['jenis_kelamin'] .
            ' | Status: ' . $studentData['status_students'];

        // Log the update action
        $logEntry = [
            'action' => 'update',
            'url' => $cleanedUrl,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode_id,
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);

        return ['success' => 'Student and User updated successfully'];
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

        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);
        $periode_id = Periode::where('actif', 1)->value('id');
        // Prepare log data with all relevant fields
        $logData = 'Nama: ' . $student->nama .
            ' | Nis: ' . $student->nis .
            ' | Kelas: ' . $student->kelas .
            ' | Jenis Kelamin: ' . $student->jenis_kelamin .
            ' | Status: ' . $student->status_students;

        // Log the deletion action
        $logEntry = [
            'action' => 'delete',
            'url' => $cleanedUrl,
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode_id,
            'user_id' => auth()->id(),
        ];

        $this->logRepository->create($logEntry);
    }

    public function findStudentByUUID($uuid)
    {
        // to find student by uuid
        return $this->studentRepository->findStudentByUUID($uuid);
    }
}
