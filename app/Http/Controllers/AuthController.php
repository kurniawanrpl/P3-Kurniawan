<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Outlet;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function formLogin()
    {
        $outlets = Outlet::all(); // ambil semua outlet
        return view('auth.login', compact('outlets')); 
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dasboard'); // nanti kita bikin
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showRegisterForm()
{
    $outlets = Outlet::all(); // ambil semua outlet
    return view('auth.login', compact('outlets')); // form login dan register di file yang sama
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'outlet_id' => 'required|exists:outlets,id',
    ], [
        // Custom pesan
        'email.unique' => 'Email sudah dipakai',
        'email.required' => 'Email wajib diisi',
        'password.required' => 'Password wajib diisi',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'name.required' => 'Nama wajib diisi',
        'outlet_id.required' => 'Outlet harus dipilih',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'outlet_id' => $request->outlet_id,
        'role' => 'pengguna', // default role
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

}
}
