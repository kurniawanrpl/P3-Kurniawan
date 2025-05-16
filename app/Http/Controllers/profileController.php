<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Outlet;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->member;
        return view('profile.index', compact('user','member'));
    }

    public function edit()
    {
        $user = Auth::user();
        $outlets = Outlet::all();
        $member = $user->member;
        // untuk dropdown outlet
        return view('profile.edit', compact('user', 'outlets', 'member'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'outlet_id' => 'nullable|exists:outlets,id',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah dipakai.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;
        $user->outlet_id = $request->outlet_id;
    
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
