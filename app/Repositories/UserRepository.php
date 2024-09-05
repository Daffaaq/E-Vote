<?php

namespace App\Repositories;

use App\Models\Log;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserRepository
{
    public function getAllUsersExceptVoter()
    {
        return User::where('role', '!=', 'voter')->get();
    }

    public function getUserByUuid($uuid)
    {
        return User::where('role', '!=', 'voter')->where('uuid', $uuid)->firstOrFail();
    }

    public function createUser($data)
    {
        $user = User::create($data);

        // Create a log entry
        $this->createLog('create', 'Created User | Name: ' . $user->name . ' | Username: ' . $user->username . ' | Role: ' . $user->role);

        return $user;
    }

    public function updateUser($uuid, $data)
    {
        $user = $this->getUserByUuid($uuid);
        $user->update($data);

        $logData = 'Updated User | Name: ' . $user->name . ' | Username: ' . $user->username . ' | Role: ' . $user->role;
        if (isset($data['password'])) {
            $logData .= ' | Password Changed';
        }

        // Create a log entry
        $this->createLog('update', $logData);

        return $user;
    }

    public function updateUsernouuid($data)
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('No authenticated user found.');
        }

        $userId = $user->id;

        $result = DB::table('users')->where('id', $userId)->update($data);

        // Prepare log data
        $logData = 'Updated User without UUID | Name: ' . $user->name . ' | Username: ' . $user->username . ' | Role: ' . $user->role;
        if (isset($data['password'])) {
            $logData .= ' | Password Changed';
        }

        // Create a log entry
        $this->createLog('update', $logData);

        return $result;
    }

    public function deleteUser($uuid)
    {
        $user = $this->getUserByUuid($uuid);
        $userId = $user->id;
        $role = $user->role;
        $user->delete();

        // Create a log entry
        $this->createLog('delete', 'Deleted User | Name: ' . $user->name . ' | Username: ' . $user->username . ' | Role: ' . $role);
    }

    public function getUsersForDataTable()
    {
        $query = User::select(['uuid', 'name', 'username', 'role'])->where('role', '!=', 'voter');
        return DataTables::of($query)->addIndexColumn()->make(true);
    }

    /**
     * Create a log entry for the performed action.
     *
     * @param string $action
     * @param string $logData
     */
    protected function createLog($action, $logData)
    {
        $log = new Log();
        $log->action = $action;
        $log->url = request()->fullUrl(); // Get the current request URL
        $log->tanggal = now()->format('Y-m-d');
        $log->waktu = now()->format('H:i:s');
        $log->data = $logData; // Use the formatted log data
        $log->periode_id = Periode::where('actif', 1)->value('id'); // Assuming the periode table has an 'actif' column
        $log->user_id = Auth::user()->id; // Correctly getting the authenticated user's ID
        $log->save();
    }
}
