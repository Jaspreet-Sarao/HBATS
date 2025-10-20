<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\visit_passcode>
 */
class VisitPasscodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition():array
    {
        return [
            'code'=>strtoupper($this->faker->bothify('???###???')),
            'expires_at'=>now()->addDays(2),
            'status'=>'active',
            'reason'=>null,
        ];
    }
}
