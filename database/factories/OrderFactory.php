<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => 'pending',
            'customer_id' => \App\Models\Customer::factory(),
            'menu_item_id' => \App\Models\MenuItem::factory(),
            'total_price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
