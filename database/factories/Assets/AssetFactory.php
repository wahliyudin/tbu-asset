<?php

namespace Database\Factories\Assets;

use App\Enums\Asset\Status;
use App\Models\Assets\Asset;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\Masters\Uom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assets\Asset>
 */
class AssetFactory extends Factory
{
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->sentence(1),
            'unit_id' => Unit::factory(),
            'sub_cluster_id' => SubCluster::factory(),
            // 'member_name' => fake()->sentence(1),
            'pic' => fake()->numberBetween(1000, 9999),
            'activity' => fake()->sentence(1),
            'asset_location' => fake()->numberBetween(1000, 9999),
            'kondisi' => fake()->sentence(1),
            'uom_id' => fake()->randomElement(Uom::query()->pluck('id')->toArray()),
            'quantity' => fake()->numberBetween(1, 10),
            'tgl_bast' => fake()->date(),
            'hm' => fake()->sentence(1),
            'pr_number' => fake()->sentence(1),
            'po_number' => fake()->sentence(1),
            'gr_number' => fake()->sentence(1),
            'remark' => fake()->sentence(1),
            'status' => fake()->randomElement(Status::cases()),
        ];
    }
}
