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
        Log::info($user);
        return [
            'attbpid' => $user->userdtbpid,
            'attuserid' => $user->userid,
            'attdate' => '2022-10-' . $this->faker->numberBetween(1, 30),
            'attclockin' => $this->faker->time(),
            'attclockout' => $this->faker->time(),
            'attlat' => $this->faker->latitude(),
            'attlong' => $this->faker->longitude(),
            'attaddress' => $this->faker->address(),
            'createdby' => 1,
            'updatedby' => 1,
        ];
    }
}
