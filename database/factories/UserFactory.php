<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'descricao' => fake()->optional(0.7)->paragraph(2),
            'email' => fake()->unique()->safeEmail(),
            'foto' => fake()->optional(0.5)->imageUrl(200, 200, 'people'),
            'creci' => fake()->optional(0.8)->numerify('CRECI-RJ ####'),
            'celular' => fake()->optional(0.9)->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['admin', 'corretor']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the user should be a corretor.
     */
    public function corretor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'corretor',
            'creci' => fake()->numerify('CRECI-RJ ####'),
        ]);
    }
}
