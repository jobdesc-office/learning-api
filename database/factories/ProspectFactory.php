<?php

namespace Database\Factories;

use App\Models\Masters\Prospect;
use App\Models\Masters\UserDetail;
use App\Models\Masters\Customer;
use App\Models\Masters\Stbptype;
use App\Services\Masters\ProspectServices;
use Illuminate\Database\Eloquent\Factories\Factory;
use FactoryCount;
use DBTypes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProspectFactory extends Factory
{
    protected $x = 0;
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
            'prospectcode' => $this->generateCode($this->x++),
            'prospectstartdate' => Carbon::create(2022, $month, $day, $hour, $minute, 0),
            'prospectenddate' => Carbon::create(2022, $month, $day, $hour, $minute, 0),
            'prospectvalue' => $this->faker->numberBetween(100000, 10000000000),
            'prospectowner' => $user->userdtid,
            'prospectstageid' => $this->getStage()->getChildrenId(),
            'prospectstatusid' => $this->getStatus()->getChildrenId(),
            'prospectexpclosedate' => Carbon::create(2022, $month, $day, $hour, $minute, 0),
            'prospectbpid' => $this->faker->numberBetween(1, FactoryCount::bpCount),
            // 'prospectbpid' => $user->userdtbpid,
            'prospectcustlabel' => $this->getLabel()->getChildrenId(),
            'prospectcustid' => $customer->cstmid,
            'createdby' => $user->userid,
        ];
    }

    function generateCode($count)
    {
        $code = "PRS";

        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $increment = str_pad($count, 4, "0", STR_PAD_LEFT);

        return "$code$year$month$increment";;
    }

    function getStatus()
    {
        $customertype = find_type()->childrenByCode([\DBTypes::prospectStatus])
            ->randomChildren();
        return $customertype;
    }

    function getStage()
    {
        $customertype = find_type()->childrenByCode([\DBTypes::prospectStage])
            ->randomChildren();
        return $customertype;
    }

    function getLabel()
    {
        $customertype = find_type()->childrenByCode([\DBTypes::prospectCustLabel])
            ->randomChildren();
        return $customertype;
    }
}
