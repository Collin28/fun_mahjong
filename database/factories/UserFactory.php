<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->numerify('081#########'),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password123',
            'birth_date' => '2000-02-29',
            'role' => 'user',
            'profile_picture' => 'panda',
        ];
    }
}
