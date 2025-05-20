<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_id' => $this->faker->uuid,
            'channel' => $this->faker->word,
            'origin_zipcode' => $this->faker->postcode,
            'origin_title' => $this->faker->company,
            'destination_city' => $this->faker->city,
            'destination_state' => $this->faker->state,
            'destination_zipcode' => $this->faker->postcode,
            'estimated_delivery' => $this->faker->date(),
            'raw' => json_encode([
                'channel' => $this->faker->word,
                'origin' => [
                    'zipcode' => $this->faker->postcode,
                    'title' => $this->faker->company,
                ],
                'destination' => [
                    'zipcode' => $this->faker->postcode,
                    'city' => $this->faker->city,
                    'state' => $this->faker->state,
                ],
                'estimated_delivery' => $this->faker->date(),
            ]),
        ];
    }
}
