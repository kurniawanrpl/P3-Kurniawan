<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class useradminController extends Controller
{
    public function index()
    {
         // Ambil semua user dengan role admin (tidak lagi difilter berdasarkan outlet)
    $users = User::where('role', 'admin')
    ->with('outlet')
    ->get();

// Ambil semua data sementara admin tanpa filter outlet
$temp_users = collect(session()->get('temp_admins', []))->values()->all();

// Ambil semua outlet
$outlets = Outlet::all();

return view('user.admin', compact('users', 'temp_users', 'outlets'));
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

        $temp = session()->get('temp_admins', []);
        $temp[] = [
            'name' => $request->name,
            'email' => $request->email,
            'outlet_id' => $request->outlet_id,
            'password' => $request->password,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ];
        session()->put('temp_admins', $temp);

        return redirect()->route('user.admin')->with('success', 'Admin ditambahkan ke daftar sementara.');
    }

    public function simpan()
    {
        $temp = session()->get('temp_admins', []);
        foreach ($temp as $item) {
            User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'outlet_id' => $item['outlet_id'],
                'telepon' => $item['telepon'] ?? null,
                'alamat' => $item['alamat'] ?? null,
                'password' => Hash::make($item['password']),
                'role' => 'admin',
            ]);
        }
        session()->forget('temp_admins');

        return redirect()->route('user.admin')->with('success', 'Semua admin berhasil disimpan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $outlets = Outlet::all();
        $users = User::where('role', 'admin')->get();
        $temp_users = session()->get('temp_admins', []);

        return view('user.admin', compact('user', 'outlets', 'users', 'temp_users'));
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
        $user->outlet_id = $request->outlet_id;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('user.admin')->with('success', 'Admin berhasil diupdate.');
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);
        $outlets = Outlet::all();
        $users = User::where('role', 'admin')->get();
        $temp_users = session()->get('temp_admins', []);

        return view('user.admin', compact('user', 'outlets', 'users', 'temp_users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.admin')->with('success', 'Admin berhasil dihapus.');
    }

    public function hapusSementara($index)
    {
        $temp = session()->get('temp_admins', []); // Ensure you're using the correct session key
        if (isset($temp[$index])) {
            unset($temp[$index]); // Remove the item from the temporary data
            session()->put('temp_admins', array_values($temp)); // Update the session with the new array
        }

        return redirect()->route('user.admin')->with('success', 'Data sementara berhasil dihapus.');
    }

    public function laporanadmin()
    {
         // Ambil semua user dengan role admin (tidak lagi difilter berdasarkan outlet)
    $users = User::where('role', 'admin')
    ->with('outlet')
    ->get();

// Ambil semua data sementara admin tanpa filter outlet
$temp_users = collect(session()->get('temp_admins', []))->values()->all();

// Ambil semua outlet
$outlets = Outlet::all();

return view('user.laporanadmin', compact('users', 'temp_users', 'outlets'));
    }

}
