<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zakat;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $payload = $request->all();

        \Log::info('Midtrans Callback Received:', $payload);

        // Verifikasi signature key
        $signatureKey = hash('sha512', 
            $payload['order_id'] . 
            $payload['status_code'] . 
            $payload['gross_amount'] . 
            env('MIDTRANS_SERVER_KEY')
        );

        if ($signatureKey !== $payload['signature_key']) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $fraudStatus = $payload['fraud_status'];

        // Cari data zakat
        $zakat = Zakat::where('kode_transaksi', $orderId)->first();

        if (!$zakat) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Update status berdasarkan callback
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $zakat->update(['status' => 'challenge']);
            } else if ($fraudStatus == 'accept') {
                $zakat->update(['status' => 'success']);
            }
        } else if ($transactionStatus == 'settlement') {
            $zakat->update(['status' => 'success']);
        } else if ($transactionStatus == 'pending') {
            $zakat->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny') {
            $zakat->update(['status' => 'deny']);
        } else if ($transactionStatus == 'expire') {
            $zakat->update(['status' => 'expire']);
        } else if ($transactionStatus == 'cancel') {
            $zakat->update(['status' => 'cancel']);
        }

        return response()->json(['status' => 'success']);
    }
}