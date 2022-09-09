<?php

namespace Database\Factories;

use App\Models\Masters\Prospect;
use App\Models\Masters\UserDetail;
use App\Models\Masters\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use FactoryCount;
use DBTypes;

class ProspectFactory extends Factory
{
    protected $model = Prospect::class;

    public function definition(): array
    {
        $customer = Customer::all()->random();
        $user = UserDetail::whereHas('user', function ($query) {
            $query->where('username', 'developer');
        })->get()->first();
        return [
            'prospectname' => $this->faker->name(),
            'prospectcode' => $this->faker->dateTime,
            'prospectstartdate' => $this->faker->dateTime,
            'prospectenddate' => $this->faker->dateTime,
            'prospectvalue' => '30000000',
            'prospectowner' => $user->userid,
            'prospectstageid' => $this->getStage()->getId(),
            'prospectstatusid' => $this->getStatus()->getId(),
            'prospectexpclosedate' => $this->faker->dateTime,
            'prospectbpid' => $user->userdtbpid,
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
