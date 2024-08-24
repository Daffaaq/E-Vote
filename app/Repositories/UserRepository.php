<?php

// app/Repositories/UserRepository.php

namespace App\Repositories;

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
        return User::create($data);
    }

    public function updateUser($uuid, $data)
    {
        $user = $this->getUserByUuid($uuid);
        $user->update($data);
        return $user;
    }
    public function updateUsernouuid($data)
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('No authenticated user found.');
        }

        $userId = $user->id;

        return DB::table('users')->where('id', $userId)->update($data);
    }

    public function deleteUser($uuid)
    {
        $user = $this->getUserByUuid($uuid);
        $user->delete();
    }

    public function getUsersForDataTable()
    {
        $query = User::select(['uuid', 'name', 'username', 'role'])->where('role', '!=', 'voter');
        return DataTables::of($query)->addIndexColumn()->make(true);
    }
}
