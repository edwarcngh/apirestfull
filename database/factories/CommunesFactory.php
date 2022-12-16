<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\regions;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\communes>
 */
class CommunesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_reg' => rand(1,5),
            'description' => $this->faker->text(20),
            'status' => 'A',
        ];
    }
}
