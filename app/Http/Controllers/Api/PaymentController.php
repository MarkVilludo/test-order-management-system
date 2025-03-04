<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function processPayment(PaymentRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = $request->user();

            $paymentData = [
                'amount'      => $validated['amount'],
                'currency'    => 'usd',
                'email'       => $user->email,
                'name'        => $user->name,
                'stripeToken' => $validated['stripeToken'], // Use provided stripeToken or generate one from card details.
            ];

            $charge = $this->paymentService->processPayment($paymentData);

            Log::info('Payment processed successfully.', [
                'charge_id' => $charge->id,
                'email'     => $user->email,
            ]);

            return response()->json([
                'success' => true,
                'charge'  => $charge,
            ]);
        } catch (Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage(), [
                'request'   => $request->all(),
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'There was a problem processing your payment. Please try again later.',
            ], 500);
        }
    }
}
