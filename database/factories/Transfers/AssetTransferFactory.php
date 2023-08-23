<?php

namespace Database\Factories\Transfers;

use App\Enums\Workflows\Status;
use App\Models\Assets\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfers\AssetTransfer>
 */
class AssetTransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_transaksi' => fake()->randomAscii(),
            'nik' => fake()->numberBetween(1000, 9999),
            'asset_id' => Asset::factory(),
            'old_pic' => fake()->numberBetween(1000, 9999),
            'old_location' => fake()->sentence(1),
            'old_divisi' => fake()->sentence(1),
            'old_department' => fake()->sentence(1),
            'new_pic' => fake()->numberBetween(1000, 9999),
            'new_location' => fake()->sentence(1),
            'new_divisi' => fake()->sentence(1),
            'new_department' => fake()->sentence(1),
            'request_transfer_date' => fake()->date(),
            'justifikasi' => fake()->sentence(1),
            'remark' => fake()->sentence(1),
            'transfer_date' => fake()->date(),
            'status' => fake()->randomElement(Status::cases()),
        ];
    }
}
