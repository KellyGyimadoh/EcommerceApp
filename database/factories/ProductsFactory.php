<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        $exdate=fake()->boolean(50)? $this->faker->dateTimeBetween('now','+120 days'): $this->faker->dateTimeBetween('+120 days','+200 days');
        return [
            'name'=>fake()->randomElement(['shoes','boot','laptop']),
            'category_id'=>Categories::factory(),
            'description'=>fake()->sentence(6),
            'price'=>fake()->randomNumber(5),
            'stock_quantity'=>fake()->randomDigit(),
            'image'=>fake()->imageUrl(),
            'status'=>fake()->randomElement([0,1]),
            'expiry_date'=>$exdate
        ];
    }

    public function forcategory($category)
    {
        return $this->state(function (array $attributes) use ($category) {
            return [
                'category_id' => $category['id'],
            ];
        });
    }
}

