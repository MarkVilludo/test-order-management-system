<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Events\OrderPlaced;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        //notify all kitchen staff of the new order.
        $kitchenStaff = User::where('role', 'kitchen_staff')->get();
        Notification::send($kitchenStaff, new OrderNotification($this->order));

        // Broadcast the event
        broadcast(new OrderPlaced($this->order))->toOthers();
    }
}
