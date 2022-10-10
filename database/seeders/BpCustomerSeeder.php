<?php

namespace Database\Seeders;

use App\Collections\Types\TypeColumn;
use App\Models\Masters\BpCustomer;
use App\Models\Masters\Customer;
use App\Models\Masters\Stbptype;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Seeder;
use Log;

class BpCustomerSeeder extends Seeder
{

   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      BpCustomer::withoutEvents(function () {
         $customers = Customer::all();
         $user = UserDetail::whereHas('user', function ($query) {
            $query->where('username', 'developer');
         })->get()->first();

         foreach ($customers as $customer) {
            $bpCustomer = new BpCustomer;
            $bpCustomer->sbcbpid = $user->userdtbpid;
            $bpCustomer->sbccstmid = $customer->cstmid;
            $bpCustomer->sbccstmstatusid = $this->getTypeid();
            $bpCustomer->sbccstmname =  $customer->cstmname;
            $bpCustomer->sbccstmaddress =  $customer->cstmaddress;
            $bpCustomer->sbccstmphone =  $customer->cstmphone;
            $bpCustomer->sbcactivitytypeid = find_type()->childrenByCode([\DBTypes::cstmactivitytype])->randomChildren()->getChildrenId();
            $bpCustomer->save();
         }
      });
   }

   function getTypeid()
   {
      $customertype = find_type()->byCode([\DBTypes::cstmstatus])
         ->children(\DBTypes::cstmstatus);
      return collect($customertype->all())->random()->getId();
   }
}
