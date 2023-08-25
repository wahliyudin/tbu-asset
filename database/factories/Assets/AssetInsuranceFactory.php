<?php

namespace Database\Factories\Assets;

use App\Models\Assets\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assets\AssetInsurance>
 */
class AssetInsuranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asset_id' => Asset::factory(),
            'jangka_waktu' => fake()->numberBetween(1, 10),
            'biaya' => fake()->randomElement([100_000, 1_000_000]),
            'legalitas' => fake()->sentence(),
        ];
    }
}
