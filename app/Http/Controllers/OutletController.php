<?php

namespace App\Http\Controllers;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    // Menampilkan semua outlet
    public function index()
    {
        $data = Outlet::all();
        return view('outlets.index', compact('data'));
    }

    // Menyimpan data sementara ke session
    public function storeTemp(Request $request)
    {
        $outlet = $request->only(['nama_outlet', 'alamat', 'telepon']);
        $outlets = session('outlets', []);
        $outlets[] = $outlet;
        session(['outlets' => $outlets]);

        return redirect()->route('outlets.index');
    }

    // Menyimpan semua data sementara ke database
    public function saveTemp()
    {
        $outlets = session('outlets', []);
        foreach ($outlets as $outletData) {
            Outlet::create($outletData);
        }
        session()->forget('outlets');

        return redirect()->route('outlets.index');
    }

    // Menghapus semua data sementara
    public function resetTemp()
    {
        session()->forget('outlets');
        return redirect()->route('outlets.index');
    }

    // Menampilkan form untuk edit outlet
    public function edit($id)
    {
        $editData = Outlet::findOrFail($id);
        return view('outlets.index', compact('editData'));
    }

    // Memperbarui data outlet
    public function update(Request $request, $id)
    {
        $outlet = Outlet::findOrFail($id);
        $outlet->update($request->only(['nama_outlet', 'alamat', 'telepon']));

        return redirect()->route('outlets.index');
    }

    // Menghapus outlet
    public function destroy($id)
    {
        Outlet::destroy($id);
        return redirect()->route('outlets.index');
    }
}