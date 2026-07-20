<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

// Dipakai di route /api/admin/*. Token bisa punya 2 "pemilik" beda:
// - App\Models\User (role admin, dari tabel `users`, login lewat /api/login)
// - App\Models\Admin (dari tabel `admins`, login khusus lewat /api/admin/login)
// Middleware ini nerima dua-duanya asal statusnya admin, biar nggak keblok
// kalau tim pakai salah satu jalur login admin.
class EnsureAdminApi
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $isAdmin = $user instanceof Admin
            || ($user instanceof \App\Models\User && $user->role === 'admin');

        if (! $isAdmin) {
            return response()->json([
                'status'  => false,
                'message' => 'Akses ditolak. Endpoint ini khusus admin.',
            ], 403);
        }

        return $next($request);
    }
}
