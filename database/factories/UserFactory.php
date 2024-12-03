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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company' => $this->faker->company(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->formatPhone($this->faker->phoneNumber()),
            'role' => 'client',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Format a phone number to a specific pattern.
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function formatPhone(string $phoneNumber): string
    {
        $numberOnly = preg_replace('/\D/', '', $phoneNumber); 
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $numberOnly);
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
     * Configure the factory to create the first user with specific attributes.
     *
     * @return static
     */
    public static function firstUser(): static
    {
        return (new static())->state([
            'company' => 'administrator',
            'phone' => '(00) 00000-0000', 
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminpass'), 
        ]);
    }

    /**
     * Configure the factory to create a second user with specific attributes.
     *
     * @return static
     */
    public static function secondUser(): static
    {
        return (new static())->state([
            'company' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'role' => 'client',
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('userpass'), 
        ]);
    }
}
