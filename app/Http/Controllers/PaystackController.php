<?php

namespace App\Http\Controllers;

use App\Mail\NewOrder;
use App\Mail\PaymentCompleted;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Services\PaystackService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaystackController extends Controller
{
    public function handleGatewayCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('cart')->with('error', 'No payment reference found.');
        }

        $paystack = new PaystackService();
        $response = $paystack->verifyPayment($reference);

        if ($response['status'] && $response['data']['status'] === 'success') {
            $payment = Payment::where('transaction_reference', $reference)->first();

            if ($payment) {
                if ($payment->status === 'completed') {
                    return redirect()->route('cart')->with('error', 'Payment not found.');
                }
                $order = Order::findOrFail($payment->order_id);

                $order->update([
                    'status' => 'processed',
                    'payment_status' => 'paid'
                ]);

                $payment->update([
                    'status' => 'completed',
                    'payment_method' => $response['data']['channel']
                ]);

                Mail::to($order->user->email)->queue(
                    new PaymentCompleted($order->total_price, $order->reference)
                );

                $users = User::where('role', 1)->get();
                if ($users) {
                    foreach ($users as $user) {
                        Mail::to($user->email)->queue(
                            new NewOrder($order->reference, $order->total_price)
                        );
                    }
                }

                ProductService::clearCart();
                return redirect()->route('order.success', $order->reference)->with('success', 'Payment successful!');
            }

            return redirect()->route('cart')->with('error', 'Payment Order not found.');
        }

        // ❌ Failed payment
        return redirect()->route('cart')->with('error', 'Payment verification failed.');
    }

    public function handle(Request $request)
    {
        Log::info('Paystack Webhook Hit');
        Log::info('Webhook Payload: ', $request->all());
        $payload = $request->all();

        Log::info('Paystack webhook received', $payload);

        // Verify the signature (OPTIONAL but recommended)
        $secret = config('paystack.secretKey');
        $signature = $request->header('x-paystack-signature');

        if (!$signature || !hash_equals(hash_hmac('sha512', $request->getContent(), $secret), $signature)) {
            return response('Unauthorized', 401);
        }

        $event = $payload['event'] ?? null;

        switch ($event) {
            case 'charge.success':
                $this->handleChargeSuccess($payload['data']);
                break;

            case 'charge.failed':
                $this->handleChargeFailed($payload['data']);
                break;

            case 'refund.processed':
                $this->handleRefundProcessed($payload['data']);
                break;
        }

        return response('Webhook Handled', 200);
    }

    private function handleChargeSuccess(array $data)
    {
        $order = Order::where('reference', $data['reference'])->first();
        $payment = Payment::where('transaction_reference', $data['reference'])->first();
        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
            $payment->update([
                'status' => 'completed'
            ]);
        }
    }

    private function handleChargeFailed(array $data)
    {
        $order = Order::where('reference', $data['reference'])->first();
        $payment = Payment::where('transaction_reference', $data['reference'])->first();
        if ($order && $order->payment_status !== 'failed') {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);
            $payment->update([
                'status' => 'failed'
            ]);
        }
    }

    private function handleRefundProcessed(array $data)
    {
        $order = Order::where('reference', $data['reference'])->first();
        $payment = Payment::where('transaction_reference', $data['reference'])->first();
        if ($order) {
            $order->update([
                'payment_status' => 'refunded',
                'status' => 'cancelled',
            ]);
            $payment->update([
                'status' => 'refunded'
            ]);
        }
    }
}
