<?php

namespace Database\Factories\Masters;

use App\Models\Masters\Cluster;
use App\Models\Masters\SubCluster;
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
            'cluster_id' => fake()->randomElement(Cluster::query()->pluck('id')->toArray()),
            'name' => fake()->sentence(2),
        ];
    }
}
