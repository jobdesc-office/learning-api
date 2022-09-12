<?php

namespace Database\Factories;

use App\Models\Masters\Prospect;
use App\Models\Masters\UserDetail;
use App\Models\Masters\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use FactoryCount;
use DBTypes;
use Carbon\Carbon;

class ProspectFactory extends Factory
{
    protected $model = Prospect::class;

    public function definition(): array
    {
        $customer = Customer::all()->random();
        $user = UserDetail::whereHas('user', function ($query) {
            $query->where('username', 'developer');
        })->get()->first();
        $month = rand(1, 12);
        $day = rand(1, 28);
        $hour = rand(0, 23);
        $minute = [0, 15, 30, 45, 59][rand(0, 4)];
        return [
            'prospectname' => $this->faker->name(),
            'prospectcode' => $this->faker->dateTime,
            'prospectstartdate' => Carbon::create(2022, $month, $day, $hour, $minute, 0),
            'prospectenddate' => Carbon::create(2022, $month, $day, $hour, $minute, 0),
            'prospectvalue' => $this->faker->numberBetween(100000, 10000000000),
            'prospectowner' => $user->userid,
            'prospectstageid' => $this->getStage()->getId(),
            'prospectstatusid' => $this->getStatus()->getId(),
            'prospectexpclosedate' => Carbon::create(2022, $month, $day, $hour, $minute, 0),
            'prospectbpid' => $this->faker->numberBetween(1, FactoryCount::bpCount),
            // 'prospectbpid' => $user->userdtbpid,
            'prospectcustlabel' => $this->getLabel()->getId(),
            'prospectcustid' => $customer->cstmid,
            'createdby' => $user->userid,
        ];
    }

    function getStatus()
    {
        $customertype = find_type()->byCode([\DBTypes::prospectStatus])
            ->children(\DBTypes::prospectStatus);
        return $customertype->random();
    }

    function getStage()
    {
        $customertype = find_type()->byCode([\DBTypes::prospectStage])
            ->children(\DBTypes::prospectStage);
        return $customertype->random();
    }

    function getLabel()
    {
        $customertype = find_type()->byCode([\DBTypes::prospectCustLabel])
            ->children(\DBTypes::prospectCustLabel);
        return $customertype->random();
    }
}
