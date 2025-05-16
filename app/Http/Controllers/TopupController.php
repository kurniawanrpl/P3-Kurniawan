<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\Member;
use App\Models\user;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;
use Midtrans\Transaction;

class TopupController extends Controller
{

    public function index()
    {
        
        return view('topup.index');
    }
    public function proses(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $order_id = 'TOPUP-' . Str::uuid();

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->name,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan data ke tabel topups
        Topup::create([
            'member_id' => auth()->user()->member->id,
            'order_id' => $order_id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return view('topup.bayar', compact('snapToken', 'order_id', 'request'));
    }

    public function cekStatus($order_id)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $status = Transaction::status($order_id);

        $topup = Topup::where('order_id', $order_id)->first();

        if ($status->transaction_status === 'settlement') {
            // Tambahkan saldo ke member
            $topup->member->increment('saldo', $topup->amount);
            $topup->status = 'settlement';
            $topup->save();

            return redirect()->route('dasboard')->with('success', 'Topup berhasil');
        }

        return redirect()->route('dasboard')->with('error', 'Pembayaran belum selesai: ' . $status->transaction_status);
    }
    public function histori()
    {
        if (in_array(auth()->user()->role, ['admin', 'supervisor', 'petugas'])) {
            $topups = Topup::with('member.user')->latest()->get();
        } elseif (auth()->user()->member) {
            // Member melihat riwayat miliknya
            $topups = auth()->user()->member->topups()->latest()->get();
        } else {
            // Role lain tanpa member, kasih data kosong
            $topups = collect(); // atau bisa redirect atau error 403
        }
    
        return view('topup.histori', compact('topups'));
    }
}