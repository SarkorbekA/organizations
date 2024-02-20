<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{

    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' =>  $this->faker->word,
            'color' =>  $this->faker->colorName,
            'year' =>  $this->faker->numberBetween(1990, 2024),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
