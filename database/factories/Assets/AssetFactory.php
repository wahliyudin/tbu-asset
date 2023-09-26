<?php

namespace Database\Factories\Assets;

use App\Enums\Asset\Status;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetUnit;
use App\Models\Masters\Activity;
use App\Models\Masters\Condition;
use App\Models\Masters\Lifetime;
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
            // 'new_id_asset' => fake()->unique()->sentence(1),
            'asset_unit_id' => AssetUnit::factory(),
            'sub_cluster_id' => SubCluster::factory(),
            // 'member_name' => fake()->sentence(1),
            'pic' => fake()->numberBetween(1000, 9999),
            'activity_id' => fake()->randomElement(Activity::query()->pluck('id')->toArray()),
            'asset_location' => fake()->numberBetween(1000, 9999),
            'condition_id' => fake()->randomElement(Condition::query()->pluck('id')->toArray()),
            'uom_id' => fake()->randomElement(Uom::query()->pluck('id')->toArray()),
            'quantity' => fake()->numberBetween(1, 10),
            'lifetime_id' => Lifetime::factory(),
            'nilai_sisa' => fake()->numberBetween(1000, 9999),
            'tgl_bast' => fake()->date(),
            'hm' => fake()->sentence(1),
            'pr_number' => fake()->sentence(1),
            'po_number' => fake()->sentence(1),
            'gr_number' => fake()->sentence(1),
            'remark' => fake()->sentence(1),
            'status' => fake()->randomElement(Status::cases()),
            'status_asset' => fake()->randomElement(Status::cases()),
        ];
    }
}
