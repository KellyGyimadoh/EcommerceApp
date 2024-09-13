<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::factory(),
            'total_price'=>fake()->randomNumber(5),
            'order_status'=>fake()->randomElement([0,1]),
            'payment_status'=>fake()->randomElement([0,1,2,3]),
            'shipping_address'=>fake()->address()
        ];
    }
}
