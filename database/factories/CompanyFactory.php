<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('pt_BR');

        return [
            'photo' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 1000) . '/640/480',
            'cnpj' => str_pad($this->faker->randomNumber(9, true), 14, '0', STR_PAD_LEFT),
            'business_name' => $this->faker->company,
            'phone' => $this->faker->numerify('###########'),
            'address' => $this->faker->address,
            'street' => $this->faker->streetName,
            'neighborhood' => $this->faker->word,
            'state' => $this->faker->stateAbbr,
            'number' => (string) $this->faker->buildingNumber,
            'city' => $this->faker->city,
            'zip_code' => $this->faker->postcode,
        ];
    }
}
