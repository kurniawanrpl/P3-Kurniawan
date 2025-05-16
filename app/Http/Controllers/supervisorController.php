<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function index()
    {
        $outletId = auth()->user()->outlet_id; // Ambil outlet dari user yang login
    
        $users = User::where('role', 'supervisor')
            ->where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_users = collect(session()->get('temp_supervisors', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get(); // Tampilkan hanya outlet milik user login
    
        return view('user.supervisor', compact('users', 'temp_users', 'outlets'));
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

        $temp = session()->get('temp_supervisors', []);
        $temp[] = [
            'name' => $request->name,
            'email' => $request->email,
            'outlet_id' => $request->outlet_id,
            'password' => $request->password,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ];
        session()->put('temp_supervisors', $temp);

        return redirect()->route('user.supervisor')->with('success', 'Supervisor ditambahkan ke daftar sementara.');
    }

    public function simpan()
    {
        $temp = session()->get('temp_supervisors', []);
        foreach ($temp as $item) {
            User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'outlet_id' => $item['outlet_id'],
                'telepon' => $item['telepon'] ?? null,
                'alamat' => $item['alamat'] ?? null,
                'password' => Hash::make($item['password']),
                'role' => 'supervisor',
            ]);
        }
        session()->forget('temp_supervisors');

        return redirect()->route('user.supervisor')->with('success', 'Semua supervisor berhasil disimpan.');
    }

    public function edit($id)
    {
        $outletId = auth()->user()->outlet_id;

        $user = User::where('id', $id)
            ->where('role', 'supervisor')
            ->where('outlet_id', $outletId)
            ->firstOrFail();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        $users = User::where('role', 'supervisor')
            ->where('outlet_id', $outletId)
            ->get();
    
        $temp_users = collect(session()->get('temp_supervisors', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        return view('user.supervisor', compact('user', 'outlets', 'users', 'temp_users'));
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

        return redirect()->route('user.supervisor')->with('success', 'Supervisor berhasil diupdate.');
    }

    public function confirmDelete($id)
    {
        $outletId = auth()->user()->outlet_id;

        $user = User::where('id', $id)
            ->where('role', 'supervisor')
            ->where('outlet_id', $outletId)
            ->firstOrFail();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        $users = User::where('role', 'supervisor')
            ->where('outlet_id', $outletId)
            ->get();
    
        $temp_users = collect(session()->get('temp_supervisors', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        return view('user.supervisor', compact('user', 'outlets', 'users', 'temp_users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.supervisor')->with('success', 'Supervisor berhasil dihapus.');
    }

    public function deleteTemp($index)
    {
        $temp = session()->get('temp_supervisors', []);
        if (isset($temp[$index])) {
            unset($temp[$index]);
            session()->put('temp_supervisors', array_values($temp));
        }

        return redirect()->route('user.supervisor')->with('success', 'Data sementara berhasil dihapus.');
    }
    public function laporansupervisor()
    {
        $outletId = auth()->user()->outlet_id; // Ambil outlet dari user yang login
    
        $users = User::where('role', 'supervisor')
            ->where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_users = collect(session()->get('temp_supervisors', []))
            ->filter(function ($user) use ($outletId) {
                return $user['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get(); // Tampilkan hanya outlet milik user login
    
        return view('user.supervisorlaporan', compact('users', 'temp_users', 'outlets'));
    }

}
