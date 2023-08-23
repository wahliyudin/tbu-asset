<?php

namespace Database\Factories\Disposes;

use App\Enums\Workflows\LastAction;
use App\Models\Disposes\AssetDispose;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposes\DisposeWorkflow>
 */
class DisposeWorkflowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sequence' => fake()->randomDigit(),
            'asset_dispose_id' => AssetDispose::factory(),
            'nik' => fake()->numberBetween(1000, 9999),
            'title' => fake()->sentence(1),
            'last_action' => fake()->randomElement(LastAction::cases()),
            'last_action_date' => fake()->date(),
        ];
    }
}
