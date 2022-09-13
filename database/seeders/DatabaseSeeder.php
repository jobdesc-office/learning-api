<?php

namespace Database\Seeders;

use App\Models\Masters\BusinessPartner;
use App\Models\Masters\ContactPerson;
use App\Models\Masters\Customer;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Schedule;
use App\Models\Masters\UserDetail;
use App\Models\Masters\Prospect;
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

        BusinessPartner::factory(\FactoryCount::bpCount)->createQuietly();
        UserDetail::factory(\FactoryCount::userDetailCount)->createQuietly();
        Schedule::factory(\FactoryCount::scheduleCount)->createQuietly();
        Customer::factory(\FactoryCount::customerCount)->createQuietly();
        DailyActivity::factory(\FactoryCount::dailyActivityCount)->createQuietly();
        Prospect::factory(\FactoryCount::prospectCount)->createQuietly();

        $this->call([BpCustomerSeeder::class]);
        $this->call([BpTypeSeeder::class]);

        ContactPerson::factory(\FactoryCount::contactCount)->createQuietly();
    }
}
