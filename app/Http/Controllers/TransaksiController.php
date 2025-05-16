<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PaketLaundry;
use App\Models\Transaksi;
use App\Models\user;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penggunas = [];
if (in_array($user->role, ['admin','supervisor', 'petugas'])) {
    $penggunas = User::where('outlet_id', $user->outlet_id)
        ->where('role', 'pengguna')
        ->get();
}
    
        $paket = PaketLaundry::where('outlet_id', $user->outlet_id)->get();
        $todo = session('transaksi_todo', []);
        $total = array_sum(array_column($todo, 'subtotal'));
    
        // Jika admin, supervisor, atau petugas: ambil semua transaksi dalam outlet
        if (in_array($user->role, ['admin', 'supervisor', 'petugas'])) {
            $transaksis = Transaksi::where('outlet_id', $user->outlet_id)
                ->orderByDesc('created_at')
                ->with('details.paket')
                ->get();
        } else {
            $transaksis = Transaksi::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->with('details.paket')
                ->get();
        }
    
        return view('transaksi.index', compact('paket', 'todo', 'total', 'user', 'transaksis','penggunas'));
    }

    public function tambahItem(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'qty' => 'required|integer|min:1',
        ]);

        $paket = PaketLaundry::findOrFail($request->paket_id);
        $item = [
            'paket_id' => $paket->id,
            'nama_paket' => $paket->nama_paket,
            'qty' => $request->qty,
            'subtotal' => $paket->harga * $request->qty,
        ];

        $data = session()->get('transaksi_todo', []);
        $data[] = $item;
        session()->put('transaksi_todo', $data);

        return back()->with('success', 'Item berhasil ditambahkan.');
    }

    public function hapusItem($key)
    {
        $data = session()->get('transaksi_todo', []);
        if (isset($data[$key])) {
            unset($data[$key]);
            session()->put('transaksi_todo', $data);
        }

        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,saldo',
        ]);

        $user = Auth::user();
        $member = $user->member;
        $todo = session('transaksi_todo', []);
        $total = array_sum(array_column($todo, 'subtotal'));

        $targetUser = $user;
if (in_array($user->role, ['admin','supervisor', 'petugas']) && $request->filled('pengguna_id')) {
    $targetUser = User::where('outlet_id', $user->outlet_id)->findOrFail($request->pengguna_id);
}

        if ($request->metode_pembayaran === 'saldo') {
            if (!$member || $member->saldo < $total) {
                return back()->with('error', 'Saldo tidak mencukupi.');
            }
            $member->saldo -= $total;
            $member->save();
        }

        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX' . time(),
            'outlet_id' => $user->outlet_id,
            'member_id' => $member->id ?? null,
            'user_id' => $user->id,
            'total' => $total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'proses',
        ]);

        foreach ($todo as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'paket_id' => $item['paket_id'],
                'qty' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        session()->forget('transaksi_todo');

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }
    public function ubahStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:proses,selesai,dibatalkan',
    ]);

    $transaksi = Transaksi::findOrFail($id);
    $user = Auth::user();

    // Jika user bukan admin/supervisor/petugas, hanya bisa batalkan milik sendiri yang masih proses
    if (!in_array($user->role, ['admin', 'supervisor', 'petugas'])) {
        if ($transaksi->user_id !== $user->id || $transaksi->status !== 'proses' || $request->status !== 'dibatalkan') {
            return back()->with('error', 'Akses tidak diizinkan.');
        }
    }

    $transaksi->status = $request->status;
    $transaksi->save();

    return back()->with('success', 'Status transaksi berhasil diubah.');
}
}