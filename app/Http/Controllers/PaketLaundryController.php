<?php

namespace App\Http\Controllers;
use App\Models\PaketLaundry;
use App\Models\Outlet;
use Illuminate\Http\Request;

class PaketLaundryController extends Controller
{
    public function index()
    {
        $outletId = auth()->user()->outlet_id;
    
        $pakets = PaketLaundry::where('outlet_id', $outletId)
            ->with('outlet')
            ->get();
    
        $temp_pakets = collect(session('temp_pakets', []))
            ->filter(function ($paket) use ($outletId) {
                return $paket['outlet_id'] == $outletId;
            })->values()->all();
    
        $outlets = Outlet::where('id', $outletId)->get();
    
        return view('paket_laundry.index', compact('pakets', 'temp_pakets', 'outlets'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required',
            'nama_paket' => 'required',
            'jenis' => 'required|in:kiloan,selimut,bed_cover,kaos,lain',
            'harga' => 'required|numeric',
        ]);

        $data = $request->only(['outlet_id', 'nama_paket', 'jenis', 'harga']);

        $temp_pakets = session('temp_pakets', []);
        $temp_pakets[] = $data;
        session(['temp_pakets' => $temp_pakets]);

        return redirect()->back()->with('success', 'Paket laundry ditambahkan ke daftar sementara.');
    }

    public function simpan()
    {
        $temp_pakets = session('temp_pakets', []);
        foreach ($temp_pakets as $item) {
            PaketLaundry::create($item);
        }
        session()->forget('temp_pakets');
        return redirect()->back()->with('success', 'Data berhasil disimpan ke database.');
    }

    public function edit($id)
    {
        $paket = PaketLaundry::findOrFail($id);
        $pakets = PaketLaundry::with('outlet')->get();
        $temp_pakets = session('temp_pakets', []);
        $outlets = Outlet::all();
        return view('paket_laundry.index', compact('pakets', 'temp_pakets', 'paket', 'outlets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'outlet_id' => 'required',
            'nama_paket' => 'required',
            'jenis' => 'required|in:kiloan,selimut,bed_cover,kaos,lain',
            'harga' => 'required|numeric',
        ]);

        $data = $request->only(['outlet_id', 'nama_paket', 'jenis', 'harga']);
        PaketLaundry::findOrFail($id)->update($data);

        return redirect()->route('paket_laundry.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PaketLaundry::findOrFail($id)->delete();
        return redirect()->route('paket_laundry.index')->with('success', 'Data berhasil dihapus.');
    }

    public function hapusSementara($index)
    {
        $temp_pakets = session('temp_pakets', []);
        unset($temp_pakets[$index]);
        session(['temp_pakets' => array_values($temp_pakets)]);
        return redirect()->back()->with('success', 'Data sementara berhasil dihapus.');
    }

    public function resetSementara()
    {
        session()->forget('temp_pakets');
        return redirect()->back()->with('success', 'Daftar sementara berhasil di-reset.');
    }

    public function confirmDelete($id)
    {
        $paket = PaketLaundry::findOrFail($id);
        $pakets = PaketLaundry::with('outlet')->get();
        $temp_pakets = session('temp_pakets', []);
        $outlets = Outlet::all();
        return view('paket_laundry.index', compact('paket', 'pakets', 'temp_pakets', 'outlets'));
    }
}