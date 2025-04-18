<?php
/**
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user adalah admin (misalnya dengan kolom 'role')
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, redirect ke dashboard biasaQAA
        return redirect('/')->with('error', 'Akses hanya untuk admin.');
    }
}

 * Summary of namespace App\Http\Middleware
 */