<?php

namespace Database\Seeders;

use App\Models\BusinessPartners\BusinessPartner;
use App\Models\Masters\BpCustomer;
use App\Models\Masters\Customer;
use App\Models\Masters\Schedule;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use FactoryCount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function run()
    {
        $this->call([TypeSeeder::class]);

        BusinessPartner::factory(\FactoryCount::bpCount)->create();
        UserDetail::factory(\FactoryCount::userDetailCount)->create();
        Schedule::factory(\FactoryCount::scheduleCount)->create();
        Customer::factory(\FactoryCount::customerCount)->create();
        BpCustomer::factory(\FactoryCount::bpCustomerCount)->create();
    }
}
