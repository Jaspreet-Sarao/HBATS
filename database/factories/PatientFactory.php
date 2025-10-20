<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'patient_identifier' => strtoupper($this->faker->bothify('PAT-#####')),
            'contact' => $this->faker->phoneNumber(),
            'emergency_contact' => $this->faker->phoneNumber(),
            'admission_notes' => $this->faker->sentence(),
            'admitted_at' => now()->subDays(rand(0, 5)),
            'discharged_at' => null,
        ];
    }
}
