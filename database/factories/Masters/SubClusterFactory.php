<?php

namespace Database\Factories\Masters;

use App\Models\Cluster;
use App\Models\SubCluster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubClusterFactory extends Factory
{
    protected $model = SubCluster::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cluster_id' => Cluster::factory(),
            'name' => fake()->sentence(2),
        ];
    }
}
