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
use Log;

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
        $json = file_get_contents("./customers.json");
        $data = json_decode($json)[$this->faker->unique()->numberBetween(0, 882)];

        return [
            'cstmname' => $this->faker->company,
            'cstmphone' => $this->faker->phoneNumber,
            'cstmaddress' => $this->faker->address,
            'cstmprovinceid' => $data->ids->province,
            'cstmcityid' => $data->ids->city,
            'cstmuvid' => $data->ids->village,
            'cstmsubdistrictid' => $data->ids->subdistrict,
            'cstmpostalcode' => $this->faker->numberBetween(30001, 39999),
            'cstmlatitude' =>  $data->coordinate[0],
            'cstmlongitude' => $data->coordinate[1],
            'cstmtypeid' => $this->getTypeId(),
        ];
    }

    function getTypeid()
    {
        $customertype = find_type()->byCode([\DBTypes::cstmtype])
            ->children(\DBTypes::cstmtype);
        return $customertype->random()->getId();
    }
}
