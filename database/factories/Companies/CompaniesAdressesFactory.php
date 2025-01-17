<?php

namespace Database\Factories\Companies;

use App\Models\Companies\Companies;
use App\Models\Companies\CompaniesAddresses;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompaniesAddressesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompaniesAddresses::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $City = $this->faker->city();

        return [
            //
            'companies_id' => $this->faker->factory(Companies::class),
            'ORDRE' => $this->faker->randomDigitNotNull(),
            'LABEL' =>$City,
            'ADRESS' => $this->faker->secondaryAddress(),
            'ZIPCODE' => $this->faker->postcode(),
            'CITY' => $City,
            'COUNTRY' => $this->faker->country(),
            'NUMBER' => $this->faker->phoneNumber(),
            'MAIL' => $this->faker->safeEmail(),
            'ADRESS_LIV' => $this->faker->numberBetween($min = 1, $max = 2),
            'ADRESS_FAC' => $this->faker->numberBetween($min = 1, $max = 2),
        ];
    }
}
