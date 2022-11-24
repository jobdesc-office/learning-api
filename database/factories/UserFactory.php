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
        $number = $this->faker->unique()->numberBetween(0, 25);
        $number = $number == 0 ? '' : $number;
        if ($number == 22) {
            return [
                'username' => 'demo',
                'userpassword' => Hash::make('demo' . $number),
                'userfullname' => "Mr. Demo",
                'useremail' => "demo@demo.demo",
                'userphone' => "08812422394523",
                'createdby' => 1,
                'updatedby' => 1,
            ];
        }
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
