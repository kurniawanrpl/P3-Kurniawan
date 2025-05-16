<?php

namespace App\Http\Controllers;
use Midtrans\Snap;
use App\Models\Member;
use App\Models\Outlet;
use Midtrans\Config;
use Illuminate\Http\Request;




class MemberController extends Controller
{
   
    public function bayarPendaftaran(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    
        $user = auth()->user();
    
        // Jika sudah member aktif (misalnya punya status 'aktif' atau status pembayaran sukses)
        if ($user->member && $user->member->midtrans_payment_status	 == 'paid') {
            return redirect()->back()->with('error', 'Anda sudah terdaftar sebagai member.');
        }
    
        // Cari data member yang belum dibayar (pending)
        $member = Member::where('user_id', $user->id)
            ->whereNull('midtrans_payment_status') // atau gunakan kolom status pembayaran jika ada
            ->first();
    
        if (!$member) {
            // Jika belum ada, buat data member baru
            $member = Member::create([
                'nama' => $request->nama,
                'user_id' => $user->id,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'outlet_id' => $user->outlet_id,
            ]);
    
            $order_id = 'REG-MEMBER-' . time();
    
            // Simpan order_id ke data member
            $member->update([
                'midtrans_order_id' => $order_id,
            ]);
        } else {
            // Jika sudah ada, gunakan order_id yang lama atau buat baru jika kosong
            $order_id = $member->midtrans_order_id ?? 'REG-MEMBER-' . time();
            $member->update(['midtrans_order_id' => $order_id]);
        }
    
        // Buat parameter untuk pembayaran
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => 50000,
            ],
            'customer_details' => [
                'first_name' => $member->nama,
                'email' => $user->email,
                'phone' => $member->telepon,
            ],
        ];
    
        $snapToken = Snap::getSnapToken($params);
    
        return view('member.bayar', compact('snapToken', 'member'));
    }public function sukses(Request $request)
{
    $member = Member::where('midtrans_order_id', $request->order_id)->firstOrFail();

    // Tandai sebagai aktif
    $member->update([
        'midtrans_payment_status' => 'paid',
    ]);

    // Ubah role user jadi pengguna
    $member->user->update([
        'role' => 'pengguna',
    ]);

    // (Opsional) Tambahkan saldo awal
    $member->increment('saldo', 50000);

    return view('member.sukses');
}

    public function index(Request $request)
    {
        // Filter outlet berdasarkan user login (jika pakai sistem login per outlet)
        $outletId = auth()->user()->outlet_id;

        // Ambil data member + user-nya
        $members = Member::with('user')
            ->where('outlet_id', $outletId)
            ->whereNotNull('user_id')
            ->get();

        return view('member.index', compact('members'));
    }
    public function destroy($id)
    {
        Member::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Member berhasil dihapus.');
    }
    

}
