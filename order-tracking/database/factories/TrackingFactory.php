<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Tracking;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackingFactory extends Factory
{
    protected $model = Tracking::class;

    public function definition()
    {
        return [
            'order_id' => function (array $attributes) {
                return Order::find($attributes['order_id'])->order_id;
            },
            'step' => $this->faker->randomElement(array_keys(Order::STEP)),
            'status' => $this->faker->sentence(),
            'message' => $this->faker->sentence(),
            'observation' => $this->faker->sentence(),
            'raw' => json_encode([
                'key' => $this->faker->word,
                'value' => $this->faker->sentence(),
            ]),
            'created_at' => now(),
        ];
    }
}
