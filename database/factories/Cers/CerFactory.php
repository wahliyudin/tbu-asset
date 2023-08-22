<?php

namespace Database\Factories\Cers;

use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Enums\Workflows\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cers\Cer>
 */
class CerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_cer' => fake()->countryCode(),
            'nik' => fake()->numberBetween(1000, 9999),
            'type_budget' => fake()->randomElement(TypeBudget::cases()),
            'budget_ref' => fake()->numberBetween(1000, 9999),
            'peruntukan' => fake()->randomElement(Peruntukan::cases()),
            'tgl_kebutuhan' => fake()->date(),
            'justifikasi' => fake()->sentence(1),
            'sumber_pendanaan' => fake()->randomElement(SumberPendanaan::cases()),
            'cost_analyst' => fake()->sentence(1),
            'status' => fake()->randomElement(Status::cases()),
        ];
    }
}
