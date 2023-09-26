<?php

namespace Database\Factories\Assets;

use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assets\AssetUnit>
 */
class AssetUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Unit::factory(),
            'kode' => fake()->unique()->sentence(1),
            'type' => fake()->sentence(),
            'seri' => fake()->sentence(),
            'class' => fake()->sentence(),
            'brand' => fake()->sentence(),
            'serial_number' => fake()->sentence(),
            'spesification' => fake()->sentence(),
            'tahun_pembuatan' => fake()->year(),
            'kelengkapan_tambahan' => fake()->sentence(),
        ];
    }
}
