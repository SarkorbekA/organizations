<?php

namespace Database\Seeders;

use App\Models\FuelSensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuelSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FuelSensor::factory()
        ->count(500)
        ->create();
    }
}
