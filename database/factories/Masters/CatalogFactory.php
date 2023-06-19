<?php

namespace Database\Factories\Masters;

use App\Models\Catalog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CatalogFactory extends Factory
{
    protected $model = Catalog::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_model' => fake()->sentence(),
            'unit_type' => fake()->sentence(),
            'seri' => fake()->sentence(),
            'unit_class' => fake()->sentence(),
            'brand' => fake()->sentence(),
            'spesification' => fake()->sentence(),
        ];
    }
}