<?php

namespace App\Services;
use App\Models\Order;
use App\Contracts\DashboardInterface;

class KitchenDashboardService implements DashboardInterface
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getIncomingOrders(int $perPage = 5)
    {
        return $this->order->with(['menuItem', 'customer'])
            ->where('status', 'pending')
            ->latest()
            ->paginate($perPage);
    }

    public function getKitchenOrders(int $perPage = 5)
    {
        return $this->order->with(['menuItem', 'customer'])
            ->whereIn('status', ['preparing', 'ready'])
            ->latest()
            ->paginate($perPage);
    }

    public function getDeliveryOrders(int $perPage = 5)
    {
        return $this->order->with(['menuItem', 'customer'])
            ->whereIn('status', ['out_for_delivery', 'delivered'])
            ->latest()
            ->paginate($perPage);
    }
}
