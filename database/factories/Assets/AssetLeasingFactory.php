<?php

namespace Database\Factories\Assets;

use App\Models\Assets\Asset;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assets\AssetLeasing>
 */
class AssetLeasingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asset_id' => fake()->randomElement(Asset::query()->pluck('id')->toArray()),
            'dealer_id' => Dealer::factory(),
            'leasing_id' => Leasing::factory(),
            'harga_beli' => fake()->randomElement([100_000, 1_000_000]),
            'jangka_waktu_leasing' => fake()->numberBetween(1, 10),
            'biaya_leasing' => fake()->randomElement([100_000, 1_000_000]),
            'legalitas' => fake()->sentence(),
        ];
    }
}
