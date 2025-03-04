<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return new Channel('orders');
    }

    public function broadcastAs()
    {
        return 'OrderPlaced';
    }

    public function broadcastWith()
    {
        // Ensure the menuItem relation is loaded.
        $this->order->load('menuItem');

        return [
            'order'     => $this->order,
            'menu_item' => $this->order->menuItem,
        ];
    }
}
