<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function handle404()
    {
        $user = Auth::user();

        if ($user) { // Memeriksa apakah pengguna sudah login
            if ($user->role == 'voter') {
                return response()->view('Error-Template.404-voter', compact('user'), 404);
            } elseif ($user->role == 'superadmin') {
                return response()->view('Error-Template.404-superadmin', compact('user'), 404);
            } elseif ($user->role == 'admin') {
                return response()->view('Error-Template.404-admin', compact('user'), 404);
            }
        }

        // Jika pengguna tidak terautentikasi atau tidak ada role yang cocok
        return response()->view('Error-Template.404-guest', [], 404);
    }

    public function handle500()
    {
        $user = Auth::user();
        Log::info('500 Error - User: ' . ($user ? $user->name : 'Guest'));

        if ($user) { // Memeriksa apakah pengguna sudah login
            if ($user->role == 'voter') {
                return response()->view('Error-Template.500-voter', compact('user'), 500);
            } elseif ($user->role == 'superadmin') {
                return response()->view('Error-Template.500-superadmin', compact('user'), 500);
            } elseif ($user->role == 'admin') {
                return response()->view('Error-Template.500-admin', compact('user'), 500);
            }
        }

        // Jika pengguna tidak terautentikasi atau tidak ada role yang cocok
        return response()->view('Error-Template.500-guest', [], 500);
    }

    public function handle403()
    {
        $user = Auth::user();
        Log::info('403 Error - User: ' . ($user ? $user->name : 'Guest'));

        if ($user) { // Memeriksa apakah pengguna sudah login
            if ($user->role == 'voter') {
                return response()->view('Error-Template.403-voter', compact('user'), 403);
            } elseif ($user->role == 'superadmin') {
                return response()->view('Error-Template.403-superadmin', compact('user'), 403);
            } elseif ($user->role == 'admin') {
                return response()->view('Error-Template.403-admin', compact('user'), 403);
            }
        }

        // Jika pengguna tidak terautentikasi atau tidak ada role yang cocok
        return response()->view('Error-Template.403-guest', [], 403);
    }
}
