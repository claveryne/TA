<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    // Membatasi akses khusus untuk user dengan role Admin
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        if ($user->role === NULL) {
            abort(403, 'Akses ditolak: Anda tidak memiliki role Admin.');
        }

        $isAdmin = $user->role === 'Admin';

        if (!$isAdmin) {
            abort(403, 'Akses hanya untuk admin!');
        }

        return $next($request);
    }
}
