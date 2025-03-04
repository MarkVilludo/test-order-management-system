<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    protected $target; // The intended recipient or target group (e.g., 'kitchen_staff')

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Order $order
     * @param string $target The target group or designation (default: 'kitchen_staff')
     */
    public function __construct(Order $order, $target = 'kitchen_staff')
    {
        $this->order = $order;
        $this->target = $target;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification for storing in the database.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message'  => 'New order placed: Order #' . $this->order->id,
            'target'   => $this->target,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'message'  => 'New order placed: Order #' . $this->order->id,
            'target'   => $this->target,
        ]);
    }
}
