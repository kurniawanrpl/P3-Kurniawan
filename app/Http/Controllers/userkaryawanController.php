<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserKaryawanController extends Controller
{
    public function index()
    {
        $outletId = auth()->user()->outlet_id;
    
        $users = User::where('role', 'petugas')
            ->where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_users = collect(session()->get('temp_karyawan', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        return view('user.karyawan', compact('users', 'temp_users', 'outlets'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'outlet_id' => 'required|exists:outlets,id',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
        ]);

        $temp_users = session('temp_karyawan', []);
        $temp_users[] = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'outlet_id' => $request->outlet_id,
            'role' => 'petugas',
        ];

        session(['temp_karyawan' => $temp_users]);
        return redirect()->back()->with('success', 'Data karyawan ditambahkan ke daftar sementara.');
    }

    public function simpan()
    {
        $temp_users = session('temp_karyawan', []);
        foreach ($temp_users as $user) {
            User::create($user);
        }

        session()->forget('temp_karyawan');
        return redirect()->back()->with('success', 'Semua data karyawan berhasil disimpan ke database.');
    }

    public function edit($id)
    {
        $outletId = auth()->user()->outlet_id;

    $user = User::where('id', $id)
        ->where('role', 'petugas')
        ->where('outlet_id', $outletId)
        ->firstOrFail();

    $users = User::where('role', 'petugas')
        ->where('outlet_id', $outletId)
        ->get();

    $temp_users = collect(session()->get('temp_karyawan', []))
        ->filter(function ($user) use ($outletId) {
            return $user['outlet_id'] == $outletId;
        })->values()->all();

    $outlets = Outlet::where('id', $outletId)->get();

        return view('user.karyawan', compact('users', 'temp_users', 'user', 'outlets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'outlet_id' => 'required|exists:outlets,id',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
        ]);

        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email', 'outlet_id', 'telepon', 'alamat']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.karyawan')->with('success', 'Data berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $outletId = auth()->user()->outlet_id;

        $user = User::where('id', $id)
            ->where('role', 'petugas')
            ->where('outlet_id', $outletId)
            ->firstOrFail();
    
        $users = User::where('role', 'petugas')
            ->where('outlet_id', $outletId)
            ->get();
    
        $temp_users = collect(session()->get('temp_karyawan', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        return view('user.karyawan', compact('users', 'temp_users', 'user', 'outlets'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.karyawan')->with('success', 'Data berhasil dihapus.');
    }

    public function hapusSementara($index)
    {
        $temp_users = session('temp_karyawan', []);
        unset($temp_users[$index]);
        session(['temp_karyawan' => array_values($temp_users)]);
        return redirect()->back()->with('success', 'Data sementara berhasil dihapus.');
    }

    public function resetSementara()
    {
        session()->forget('temp_karyawan');
        return redirect()->back()->with('success', 'Daftar sementara berhasil di-reset.');
    }
    public function laporanpetugas()
    {
        $outletId = auth()->user()->outlet_id;
    
        $users = User::where('role', 'petugas')
            ->where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_users = collect(session()->get('temp_karyawan', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        return view('user.karyawanlaporan', compact('users', 'temp_users', 'outlets'));
    }
}
