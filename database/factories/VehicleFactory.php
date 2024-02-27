<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $random_letter = strtoupper(Str::random(1));

        $random_number = $this->faker->unique()->numberBetween(100, 999);

        $car_number = $random_letter . $random_letter . $random_number . $random_letter;

        return [
            'model' =>  $this->faker->word,
            'color' =>  $this->faker->colorName,
            'year' =>  $this->faker->numberBetween(1990, 2024),
            'car_number' =>  $car_number,
            'organization_id' =>  $this->faker->numberBetween(1, 20),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
