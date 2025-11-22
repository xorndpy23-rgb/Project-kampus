<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false; // Set true untuk production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createPayment(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . uniqid(),
                'gross_amount' => 100000,
            ],
            'customer_details' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '08123456789',
            ],
            'item_details' => [
                [
                    'id' => 'item1',
                    'price' => 50000,
                    'quantity' => 2,
                    'name' => 'Donasi Masjid'
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $params['transaction_details']['order_id']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function paymentPage()
    {
        return view('payment');
    }

    public function handleNotification(Request $request)
    {
        $notification = $request->all();
        
        // Handle notification dari Midtrans
        $orderId = $notification['order_id'];
        $statusCode = $notification['status_code'];
        $grossAmount = $notification['gross_amount'];
        $transactionStatus = $notification['transaction_status'];
        
        // Update status pembayaran di database Anda
        // Contoh: Order::where('order_id', $orderId)->update(['status' => $transactionStatus]);
        
        \Log::info('Midtrans Notification:', $notification);
        
        return response()->json(['status' => 'success']);
    }

    public function paymentSuccess()
    {
        return view('payment-success');
    }

    public function paymentFailed()
    {
        return view('payment-failed');
    }
}