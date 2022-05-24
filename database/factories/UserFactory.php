<?php

namespace Database\Factories;

use App\Models\Masters\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number = $this->faker->numberBetween(0, 25);
        $number = $number == 0 ? '' : $number;
        return [
            'username' => 'developer' . ($number == 0 ? '' : $number),
            'userpassword' => Hash::make('user123' . $number),
            'userfullname' => $this->faker->name,
            'useremail' => $this->faker->email,
            'userphone' => $this->faker->phoneNumber,
            'createdby' => 1,
            'updatedby' => 1,
        ];
    }
}
