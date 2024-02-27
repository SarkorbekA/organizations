<?php

namespace Database\Factories;

use App\Models\FuelSensor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuelSensor>
 */
class FuelSensorFactory extends Factory
{
    protected $model = FuelSensor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'fuel_level' => $this->faker->numberBetween(0, 100),
            'vehicle_id' => $this->faker->numberBetween(1, 30),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
