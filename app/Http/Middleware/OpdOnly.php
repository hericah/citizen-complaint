<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class OpdOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get current user info from session
        $email = session('email');
        $namaPengguna = session('nama_pengguna');

        if (!$email && !$namaPengguna) {
            return redirect('/login');
        }

        // Check if user exists in pengguna table
        $pengguna = DB::table('pengguna')
            ->where('email', $email)
            ->orWhere('nama_pengguna', $namaPengguna)
            ->first();

        if (!$pengguna) {
            return response('Unauthorized: User not found', 403);
        }

        // Check if user has OPD assignment (opd_pengguna record)
        // This means they are OPD staff, not admin
        $opdAssignment = DB::table('opd_pengguna')
            ->where('pengguna_id', $pengguna->id)
            ->exists();

        if (!$opdAssignment) {
            return response('Unauthorized: Only OPD staff can access this page', 403);
        }

        return $next($request);
    }
}
