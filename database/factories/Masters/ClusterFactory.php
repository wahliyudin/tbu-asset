<?php

namespace Database\Factories\Masters;

use App\Masters\Models\Category;
use App\Masters\Models\Cluster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClusterFactory extends Factory
{
    protected $model = Cluster::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->sentence(2),
        ];
    }
}
