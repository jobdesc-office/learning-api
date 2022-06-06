<?php

namespace Database\Factories;

use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailFactory extends Factory
{

    protected $model = UserDetail::class;

    public function definition()
    {
        return [
            'userdtbpid' => $this->faker->numberBetween(1, 5),
            'userid' => User::factory(),
            'createdby' => 1,
            'updatedby' => 1,
            'userdttypeid' => find_type()->in([\DBTypes::roleSuperAdmin])->get()->getId(),
        ];
    }
}
