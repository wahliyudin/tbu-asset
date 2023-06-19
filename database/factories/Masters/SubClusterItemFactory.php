<?php

namespace Database\Factories\Masters;

use App\Models\Masters\SubCluster;
use App\Models\Masters\SubClusterItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubClusterItemFactory extends Factory
{
    protected $model = SubClusterItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sub_cluster_id' => SubCluster::factory(),
            'name' => fake()->sentence(2),
        ];
    }
}
