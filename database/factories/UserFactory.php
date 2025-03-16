<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('pt_BR');

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('###########'),
            'role' => 'client',
            'password' => Hash::make('password'),
            'company_id' => null,
        ];
    }
}
