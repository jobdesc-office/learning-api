<?php

namespace Database\Factories;

use App\Models\Masters\City;
use App\Models\Masters\Country;
use App\Models\Masters\Customer;
use App\Models\Masters\Province;
use App\Models\Masters\Subdistrict;
use App\Models\Masters\Village;
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
        $this->setVillageId();
        $this->setSubdistrictId();
        $this->setCityId();
        $this->setProvinceId();
        return [
            'cstmname' => $this->faker->company,
            'cstmphone' => $this->faker->phoneNumber,
            'cstmaddress' => $this->faker->address,
            'cstmprovinceid' => $this->province->provid,
            'cstmcityid' => $this->city->cityid,
            'cstmuvid' => $this->village->villageid,
            'cstmsubdistrictid' => $this->subdistrict->subdistrictid,
            'cstmpostalcode' => $this->faker->numberBetween(30001, 39999),
            'cstmlatitude' => $this->faker->latitude,
            'cstmlongitude' => $this->faker->longitude,
            'cstmtypeid' => $this->getTypeId(),
        ];
    }

    function getTypeid()
    {
        $customertype = find_type()->byCode([\DBTypes::cstmtype])
            ->children(\DBTypes::cstmtype);
        return $customertype->random()->getId();
    }

    function setVillageId()
    {
        $this->village = Village::all()->random();
    }

    function setSubdistrictId()
    {
        $this->subdistrict = $this->village->villagesubdistrict;
    }

    function setCityId()
    {
        $this->city = $this->subdistrict->subdistrictcity;
    }

    function setProvinceId()
    {
        $this->province = $this->city->cityprov;
    }
}
