<?php

namespace Database\Factories\Masters;

use App\Models\Masters\Category;
use App\Models\Masters\Cluster;
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
            'category_id' => fake()->randomElement(Category::query()->pluck('id')->toArray()),
            'name' => fake()->sentence(2),
        ];
    }
}