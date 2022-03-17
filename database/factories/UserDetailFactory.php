<?php

namespace Database\Factories;

use App\Models\Masters\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailFactory extends Factory
{

    protected $model = UserDetail::class;

    public function definition()
    {
        return [
            'bpid' => $this->faker->numberBetween(1, 5),
            'createdby' => 1,
            'updatedby' => 1
        ];
    }
}
