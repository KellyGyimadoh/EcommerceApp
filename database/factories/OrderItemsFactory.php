<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItems>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'=>Orders::factory(),
            'product_id'=>Products::factory(),
            'quantity'=>fake()->randomDigit(),
            'price'=>fake()->randomNumber(5),
        ];
    }
}
