<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $signatureKey = $request->signature_key;
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $member = Member::where('midtrans_order_id', $orderId)->first();

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $transactionStatus = $request->transaction_status;

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $amount = (float) $grossAmount;

            // Tambah saldo
            $member->saldo += $amount;
            $member->midtrans_payment_status = $transactionStatus;
            $member->save();

            Log::info("Topup berhasil untuk Member ID {$member->id} sebesar {$amount}");
        } else {
            $member->midtrans_payment_status = $transactionStatus;
            $member->save();

            Log::warning("Topup pending/gagal untuk Order ID: {$orderId}");
        }

        return response()->json(['message' => 'Callback processed']);
    }
}