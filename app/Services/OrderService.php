<?php

namespace App\Services;

use App\Models\Order;
use App\Services\{UserService, PaymentService};
use Illuminate\Support\Facades\DB;
use App\Contracts\OrderInterface;

class OrderService implements OrderInterface
{
    protected $userService;
    protected $paymentService;

    public function __construct(UserService $userService, PaymentService $paymentService)
    {
        $this->userService = $userService;
        $this->paymentService = $paymentService;
    }

    /**
     * Create an order using the validated data.
     *
     * @param  array  $data
     * @param  int    $customerId
     * @return \App\Models\Order
     */
    public function createOrder(array $data, int $customerId): Order
    {
        $existingOrder = Order::where('customer_id', $customerId)
        ->where('menu_item_id', $data['menu_item_id'])
        ->where('total_price', $data['total_price'])
        ->where('status', 'pending')
        ->first();

        if ($existingOrder) {
            //avoid duplicate store of data
            return $existingOrder;
        }

        return DB::transaction(function () use ($data, $customerId) {
            $order = Order::create([
                'customer_id'      => $customerId,
                'menu_item_id' => $data['menu_item_id'],
                'total_price'  => $data['total_price'],
                'status'       => 'pending', // Set default status
            ]);
            return $order;
        });

    }

    /**
     * Retrieve all orders with the associated menu item, ordered by latest.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrders($perPage = 5)
    {
        return Order::with(['menuItem', 'customer'])
            ->latest()
            ->paginate($perPage);
    }
}
