<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ward>
 */
class WardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition():array
    {
        $names=['ICU', 'General','Pediatric','Emergency'];
        $name=$this->faker->randomElement($names);
        return [
            'name'=>$name.'Ward',
            'code'=>strtoupper(substr($name,0,3)).'-'.str_pad((string)$this->faker->unique()->numberBetween(1,999), 3,'0', STR_PAD_LEFT),
            'total_beds'=> $this->faker->numberBetween(6,12),
        ];
    }
}
