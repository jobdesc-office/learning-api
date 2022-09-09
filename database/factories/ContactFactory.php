<?php

namespace Database\Factories;

use App\Models\Masters\ContactPerson;
use App\Models\Masters\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Log;

class ContactFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
   protected $model = ContactPerson::class;

   /**
    * Define the model's default state.
    *
    * @return array
    */
   public function definition()
   {
      $customer = Customer::all()->random();
      $type = $this->getType();
      $value = "";

      if ($type->getName() == "Phone") {
         $value = $this->faker->phoneNumber();
      } else if ($type->getName() == "Email") {
         $value = $this->faker->email();
      } else {
         $value = $this->faker->userName();
      }

      return [
         "contactcustomerid" => $customer->cstmid,
         "contacttypeid" => $type->getId(),
         "contactvalueid" => $value,
         "contactname" => $this->faker->name(),
         "createdby" => 1,
         "updatedby" => 1,
         'isactive' => true,
      ];
   }

   function getType()
   {
      $customertype = find_type()->byCode([\DBTypes::contactType])
         ->children(\DBTypes::contactType);
      return $customertype->random();
   }
}
