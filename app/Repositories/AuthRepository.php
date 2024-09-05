<?php

namespace App\Repositories;

use App\Models\Log;
use App\Models\User;
use App\Models\Students;
use Illuminate\Support\Facades\Auth;

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

        $logData = 'Updated User | Name: ' . $user->name .
            ' | Username: ' . $user->username .
            (isset($data['password']) ? ' | Password Changed' : '');

        // Create a log entry
        $this->createLog('update', $user->id, $logData);

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

            // Prepare detailed log data
            $logData = 'Updated Student | Nama: ' . $student->nama .
                ' | NIS: ' . $student->nis .
                ' | Jenis Kelamin: ' . $student->jenis_kelamin;

            // Create a log entry
            $this->createLog('update', $userId, $logData);
        }

        return $student;
    }

    protected function createLog($action, $userId, $logData)
    {
        $log = new Log();
        $log->action = $action;
        $log->url = request()->fullUrl(); // Get the current request URL
        $log->tanggal = now()->format('Y-m-d');
        $log->waktu = now()->format('H:i:s');
        $log->data = $logData; // Use the formatted log data
        $log->periode_id = Auth::user()->periode_id ?? null; // Assuming the user has a periode_id attribute
        $log->user_id = $userId;
        $log->save();
    }
}
