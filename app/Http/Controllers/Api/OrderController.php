<?php

namespace App\Http\Controllers\Api;

use App\Jobs\ProcessOrderJob;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use App\Contracts\OrderInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        try {
            $orders = $this->orderService->getOrders(10);
            return response()->json([
                'success' => true,
                'orders'  => $orders,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to fetch orders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Could not fetch orders. Please try again later.',
            ], 500);
        }
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $validated = $request->validated();
            $customerId = $request->user()->id;

            $order = $this->orderService->createOrder($validated, $customerId);
            dispatch(new ProcessOrderJob($order));

            return response()->json([
                'success' => true,
                'order'   => $order,
            ], 201);
        } catch (Exception $e) {

            return $e;
            $filteredRequest = $request->except(['password', 'credit_card_number']);

            Log::error(sprintf('Failed to store order: %s', $e->getMessage()), [
                'customer_id'   => $customerId,
                'request'   => $filteredRequest,
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'There was a problem processing your order. Please try again later.',
            ], 500);
        }
    }
}
