<?php

namespace Database\Factories;

use App\Models\Masters\Attendance;
use App\Models\Masters\UserDetail;
use FactoryCount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Log;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $user = UserDetail::whereHas('user', function ($query) {
            $query->where('username', 'developer');
        })->get()->first();
        return [
            'attbpid' => $user->userdtbpid,
            'attuserid' => $user->userid,
            'attdate' => '2022-10-' . $this->faker->numberBetween(1, 30),
            'attclockin' => $this->faker->time(),
            'attclockout' => $this->faker->time(),
            'attlatin' => $this->faker->latitude(),
            'attlongin' => $this->faker->longitude(),
            'attlatout' => $this->faker->latitude(),
            'attlongout' => $this->faker->longitude(),
            'attaddressin' => $this->faker->address(),
            'attaddressout' => $this->faker->address(),
            'createdby' => 1,
            'updatedby' => 1,
        ];
    }
}
