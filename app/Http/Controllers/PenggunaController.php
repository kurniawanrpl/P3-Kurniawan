<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $outletId = auth()->user()->outlet_id; // Ambil outlet dari user yang sedang login
    
        $users = User::where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_users = collect(session()->get('temp_penggunas', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get(); // Hanya outlet sesuai user login
    
        return view('user.pengguna', compact('users', 'temp_users', 'outlets'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'outlet_id' => 'required',
            'password' => 'required|min:4',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
        ]);

        $temp = session()->get('temp_penggunas', []);
        $temp[] = [
            'name' => $request->name,
            'email' => $request->email,
            'outlet_id' => $request->outlet_id,
            'password' => $request->password,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ];
        session()->put('temp_penggunas', $temp);

        return redirect()->route('user.pengguna')->with('success', 'Pengguna ditambahkan ke daftar sementara.');
    }

    public function simpan()
    {
        $temp = session()->get('temp_penggunas', []);
        foreach ($temp as $item) {
            User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'outlet_id' => $item['outlet_id'],
                'password' => Hash::make($item['password']),
                'telepon' => $item['telepon'] ?? null,
                'alamat' => $item['alamat'] ?? null,
                'role' => 'pengguna',
            ]);
        }
        session()->forget('temp_penggunas');

        return redirect()->route('user.pengguna')->with('success', 'Semua pengguna berhasil disimpan.');
    }

    public function edit($id)
    {
        $outletId = auth()->user()->outlet_id;

        $user = User::where('id', $id)
            ->where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->firstOrFail();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        $users = User::where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->get();
    
        $temp_users = collect(session()->get('temp_penggunas', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        return view('user.pengguna', compact('user', 'outlets', 'users', 'temp_users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'outlet_id' => 'required',
            'telepon' => 'nullable',
    'alamat' => 'nullable',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;
        $user->outlet_id = $request->outlet_id;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('user.pengguna')->with('success', 'Pengguna berhasil diupdate.');
    }

    public function confirmDelete($id)
    {
        $outletId = auth()->user()->outlet_id;

        $user = User::where('id', $id)
            ->where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->firstOrFail();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        $users = User::where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->get();
    
        $temp_users = collect(session()->get('temp_penggunas', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    

        return view('user.pengguna', compact('user', 'outlets', 'users', 'temp_users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function deleteTemp($index)
    {
        $temp = session()->get('temp_penggunas', []);
        if (isset($temp[$index])) {
            unset($temp[$index]);
            session()->put('temp_penggunas', array_values($temp));
        }

        return redirect()->route('user.pengguna')->with('success', 'Data sementara berhasil dihapus.');
    }
    public function laporanpengguna()
    {
        $outletId = auth()->user()->outlet_id; // Ambil outlet dari user yang sedang login
    
        $users = User::where('role', 'pengguna')
            ->where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_users = collect(session()->get('temp_penggunas', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get(); // Hanya outlet sesuai user login
    
        return view('user.penggunalaporan', compact('users', 'temp_users', 'outlets'));
    }
}
