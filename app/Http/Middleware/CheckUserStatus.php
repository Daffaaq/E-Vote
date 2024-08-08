<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'voter') {
            // Check if the user has a related student record
            if ($user->student && $user->student->status_students !== 1) {
                Auth::logout(); // Logout pengguna
                return redirect()->route('login')->withErrors('Akun Anda tidak aktif. Harap hubungi administrator.');
            }
        }

        return $next($request);
    }
}
