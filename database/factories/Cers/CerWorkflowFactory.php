<?php

namespace Database\Factories\Cers;

use App\Enums\Workflows\LastAction;
use App\Models\Cers\Cer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cers\CerWorkflow>
 */
class CerWorkflowFactory extends Factory
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
            'cer_id' => Cer::factory(),
            'nik' => fake()->numberBetween(1000, 9999),
            'title' => fake()->sentence(1),
            'last_action' => fake()->randomElement(LastAction::cases()),
            'last_action_date' => fake()->date(),
        ];
    }
}
