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
        Log::info('Midtrans Callback Received:', $payload);

        // 1. Validasi Signature Key
        
        $generatedSignature = hash('sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            env('MIDTRANS_SERVER_KEY')
        );

        if (($payload['signature_key'] ?? '') !== $generatedSignature) {
            Log::error('Invalid signature', [
                'payload_signature' => $payload['signature_key'] ?? '',
                'generated_signature' => $generatedSignature,
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid signature'
            ], 403);
        }

        // 2. Cari data zakat
        
        $zakat = Zakat::where('kode_transaksi', $payload['order_id'])->first();

        if (!$zakat) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order not found'
            ], 404);
        }

    
        // 3. Update status berdasarkan callback
        
        $transaction = $payload['transaction_status'];
        $fraud       = $payload['fraud_status'] ?? null;

        $statusMap = [
            'capture'    => ($fraud === 'challenge' ? 'challenge' : 'success'),
            'settlement' => 'success',
            'pending'    => 'pending',
            'deny'       => 'deny',
            'expire'     => 'expire',
            'cancel'     => 'cancel',
        ];

        $zakat->update(['status' => $statusMap[$transaction] ?? $zakat->status]);

        // 4. Kirim email jika sukses
       
        if ($zakat->status === 'success') {
            try {
                Mail::to($zakat->email)->send(new ZakatPaid($zakat));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Callback received successfully'], 200);
    }
}
