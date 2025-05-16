<?php

namespace App\Http\Controllers;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class settingController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $outlet = Outlet::findOrFail($user->outlet_id); // Ambil outlet dari user
    
        return view('setting.edit', compact('user', 'outlet'));
    }
    public function update(Request $request)
{
    $request->validate([
        'nama_outlet' => 'required|string',
        'alamat' => 'required|string',
        'telepon' => 'required|string',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg',
    ]);

    $outlet = Outlet::findOrFail(auth()->user()->outlet_id);

    $data = $request->only(['nama_outlet', 'alamat', 'telepon']);

    // kalau upload foto
    
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/outlet'), $filename);
        $data['foto'] = $filename;
    }

    $outlet->update($data);

    return back()->with('success', 'Pengaturan outlet berhasil diperbarui.');
}
}
