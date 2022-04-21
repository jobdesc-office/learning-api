<?php

namespace Database\Factories;

use App\Models\Masters\Customer;
use App\Models\Masters\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cstmname' => $this->faker->company,
            'cstmphone' => $this->faker->phoneNumber,
            'cstmaddress' => $this->faker->address,
            'cstmprovinceid' => $this->faker->numberBetween(1, 34),
            'cstmcityid' => $this->faker->numberBetween(1, 10),
            'cstmsubdistrictid' => $this->faker->numberBetween(1, 10),
            'cstmpostalcode' => $this->faker->numberBetween(30001, 39999),
            'cstmlatitude' => $this->faker->latitude,
            'cstmlongitude' => $this->faker->longitude,
        ];
    }
}
