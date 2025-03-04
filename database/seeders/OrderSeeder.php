<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $orderStatuses = [
            'pending'          => 5,
            'preparing'        => 3,
            'ready'            => 2,
            'out_for_delivery' => 3,
            'delivered'        => 2,
        ];

        foreach ($orderStatuses as $status => $count) {
            Order::factory()->count($count)->create([
                'status' => $status,
            ]);
        }
    }
}
