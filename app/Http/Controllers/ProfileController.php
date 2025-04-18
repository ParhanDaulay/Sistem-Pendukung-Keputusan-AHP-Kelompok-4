<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        // Kosongkan sementara
        return back()->with('success', 'Profil diperbarui');
    }

    public function destroy(Request $request)
    {
        // Kosongkan sementara
        return back()->with('success', 'Akun dihapus');
    }
}
