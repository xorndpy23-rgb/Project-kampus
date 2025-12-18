<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zakat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZakatPaid;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Callback Received', $payload);

        /**
         * =====================================================
         * 1. VALIDASI SIGNATURE KEY (WAJIB)
         * =====================================================
         */
        $serverKey = config('services.midtrans.server_key');

        $generatedSignature = hash(
            'sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            $serverKey
        );

        if (($payload['signature_key'] ?? '') !== $generatedSignature) {
            Log::error('Invalid Midtrans signature', [
                'expected' => $generatedSignature,
                'received' => $payload['signature_key'] ?? null,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature'
            ], 403);
        }

        /**
         * =====================================================
         * 2. CARI DATA ZAKAT
         * =====================================================
         */
        $zakat = Zakat::where('kode_transaksi', $payload['order_id'])->first();

        if (!$zakat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        /**
         * =====================================================
         * 3. UPDATE STATUS TRANSAKSI (KONSISTEN)
         * =====================================================
         */
        $transactionStatus = $payload['transaction_status'];
        $fraudStatus       = $payload['fraud_status'] ?? null;

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            if ($fraudStatus === 'challenge') {
                $zakat->status = 'pending';
            } else {
                $zakat->status = 'paid';
            }
        } elseif ($transactionStatus === 'pending') {
            $zakat->status = 'pending';
        } else {
            $zakat->status = 'failed';
        }

        $zakat->payment_method = $payload['payment_type'] ?? null;
        $zakat->save();

        /**
         * =====================================================
         * 4. KIRIM EMAIL (HANYA JIKA SUKSES)
         * =====================================================
         */
        if ($zakat->status === 'paid') {
            try {
                Mail::to($zakat->email)->send(new ZakatPaid($zakat));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email zakat: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Callback processed'
        ], 200);
    }
}
