<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsersExceptVoter();
        return view('Superadmin.Users.index', compact('users'));
    }

    public function list()
    {
        return $this->userService->getUsersForDataTable();
    }

    public function create()
    {
        return view('Superadmin.Users.create');
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($uuid)
    {
        $user = $this->userService->getUserByUuid($uuid);
        return view('users.show', compact('user'));
    }

    public function edit($uuid)
    {
        $user = $this->userService->getUserByUuid($uuid);
        return view('Superadmin.Users.edit', compact('user'));
    }

    public function update(UserRequest $request, $uuid)
    {
        $user = $this->userService->updateUser($uuid, $request->validated());
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($uuid)
    {
        $this->userService->deleteUser($uuid);
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
