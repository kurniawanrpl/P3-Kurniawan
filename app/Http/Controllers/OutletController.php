<?php

namespace App\Http\Controllers;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    // Menampilkan semua outlet
    public function index()
    {
        $outlets = Outlet::all();
        $temp_outlets = session('temp_outlets', []);
        return view('outlets.index', compact('outlets', 'temp_outlets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_outlet' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $data = $request->only(['nama_outlet', 'alamat', 'telepon']);
    
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/outlet'), $filename);
            $data['foto'] = $filename;
        }
    
        $temp_outlets = session('temp_outlets', []);
        $temp_outlets[] = $data;
        session(['temp_outlets' => $temp_outlets]);
    
        return redirect()->back()->with('success', 'Data ditambahkan ke daftar sementara.');
    }
    public function simpan()
    {
        $temp_outlets = session('temp_outlets', []);
        foreach ($temp_outlets as $item) {
            Outlet::create($item);
        }
        session()->forget('temp_outlets');

        return redirect()->back()->with('success', 'Data berhasil disimpan ke database.');
    }

    public function edit($id)
    {
        $outlet = Outlet::findOrFail($id);
        $outlets = Outlet::all();
        $temp_outlets = session('temp_outlets', []);
        return view('outlets.index', compact('outlets', 'temp_outlets', 'outlet'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_outlet' => 'required',
        'alamat' => 'required',
        'telepon' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->only(['nama_outlet', 'alamat', 'telepon']);

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/outlet'), $filename);
        $data['foto'] = $filename;
    }

    Outlet::findOrFail($id)->update($data);

    return redirect()->route('outlets.index')->with('success', 'Data berhasil diperbarui.');
}
    public function destroy($id)
    {
        Outlet::findOrFail($id)->delete();
        return redirect()->route('outlets.index')->with('success', 'Data berhasil dihapus.');
    }

    public function hapusSementara($index)
    {
        $temp_outlets = session('temp_outlets', []);
        unset($temp_outlets[$index]);
        session(['temp_outlets' => array_values($temp_outlets)]);

        return redirect()->back()->with('success', 'Data sementara berhasil dihapus.');
    }
    

    public function resetSementara()
    {
        session()->forget('temp_outlets');
        return redirect()->back()->with('success', 'Daftar sementara berhasil di-reset.');
    }
    public function confirmDelete($id)
{
    $outlet = Outlet::findOrFail($id);
    $outlets = Outlet::all();
    $temp_outlets = session('temp_outlets', []);
    return view('outlets.index', compact('outlet', 'outlets', 'temp_outlets'));
}
}