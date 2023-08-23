<?php

namespace Database\Factories\Disposes;

use App\Enums\Disposes\Dispose\Pelaksanaan;
use App\Enums\Workflows\Status;
use App\Models\Assets\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposes\AssetDispose>
 */
class AssetDisposeFactory extends Factory
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
            'no_dispose' => fake()->randomAscii(),
            'nik' => fake()->numberBetween(1000, 9999),
            'nilai_buku' => fake()->numberBetween(1000, 9999),
            'est_harga_pasar' => fake()->numberBetween(1000, 9999),
            'notes' => fake()->sentence(1),
            'justifikasi' => fake()->sentence(1),
            'pelaksanaan' => fake()->randomElement(Pelaksanaan::cases()),
            'remark' => fake()->sentence(1),
            'status' => fake()->randomElement(Status::cases()),
        ];
    }
}
