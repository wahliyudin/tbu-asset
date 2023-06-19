<?php

namespace Database\Factories\Masters;

use App\Masters\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->sentence(1),
            'model' => fake()->sentence(1),
            'type' => fake()->sentence(1),
            'seri' => fake()->sentence(1),
            'class' => fake()->sentence(1),
            'brand' => fake()->sentence(1),
            'serial_number' => fake()->sentence(1),
            'spesification' => fake()->sentence(1),
            'tahun_pembuatan' => fake()->year(),
        ];
    }
}
