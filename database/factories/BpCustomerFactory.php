<?php

namespace Database\Factories;

use App\Models\Masters\BpCustomer;
use App\Models\Masters\Customer;
use FactoryCount;
use Illuminate\Database\Eloquent\Factories\Factory;

class BpCustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BpCustomer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->prepareAttributes();
        return [
            'bpid' => $this->businessPartnerId,
            'customerid' => $this->customerId,
            'customername' => $this->getCustomer()->customername,
            'customerphone' => $this->getCustomer()->customerphone,
            'customeraddress' => $this->getCustomer()->customeraddress,
            'customerpic' => $this->faker->imageUrl(480, 480),
        ];
    }

    function prepareAttributes()
    {
        $ids = $this->getCombination()[$this->faker->unique->numberBetween(0, FactoryCount::bpCustomerCount - 1)];
        $this->customerId = $ids['customerid'];
        $this->businessPartnerId = $ids['bpid'];
    }

    function getCustomer()
    {
        return Customer::find($this->customerId);
    }

    function getCombination()
    {
        $arr = [];
        for ($i = 1; $i <= FactoryCount::bpCount; $i++) {
            for ($j = 1; $j <= FactoryCount::customerCount; $j++) {
                $arr[] = [
                    'bpid' => $i,
                    'customerid' => $j,
                ];
            }
        }
        return $arr;
    }
}
