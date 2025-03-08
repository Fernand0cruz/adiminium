<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('pt_BR');

        return [
            'company_id' => null,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('###########'),
            'role' => 'client',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public static function firstUser(): static
    {
        $faker = \Faker\Factory::create('pt_BR');

        return (new static())->state([
            'phone' => $faker->numerify('###########'), 
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminpass'), 
        ]);
    }

    public static function secondUser(): static
    {
        $faker = \Faker\Factory::create('pt_BR');

        return (new static())->state([
            'phone' => $faker->numerify('###########'),
            'role' => 'client',
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('userpass'), 
        ]);
    }
}
