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
            'customername' => $this->faker->company,
            'customerphone' => $this->faker->phoneNumber,
            'customeraddress' => $this->faker->address,
            'customerproviceid' => $this->faker->numberBetween(1, 34),
            'customercityid' => $this->faker->numberBetween(1, 10),
            'customersubdistrictid' => $this->faker->numberBetween(1, 10),
            'customerpostalcode' => $this->faker->numberBetween(30001, 39999),
            'customerlatitude' => $this->faker->latitude,
            'customerlongitude' => $this->faker->longitude,
        ];
    }
}
