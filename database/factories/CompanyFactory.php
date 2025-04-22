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
            'image' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 1000) . '/640/480',
            'business_name' => $this->faker->company,
            'cnpj' => str_pad($this->faker->randomNumber(9, true), 14, '0', STR_PAD_LEFT),
            'phone' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'web_site' => 'https://' . $this->faker->domainName(),
            'address' => $this->faker->address,
            'state' => $this->faker->stateAbbr,
            'city' => $this->faker->city,
            'zip_code' => $this->faker->postcode,
            'neighborhood' => $this->faker->word,
            'street' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
        ];
    }
}
