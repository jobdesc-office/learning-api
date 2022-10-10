<?php

namespace Database\Seeders;

use App\Models\Masters\Attendance;
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
        $this->call([InformationSeeder::class]);
        $this->call([TypeSeeder::class]);
        $this->call([PermissionSeeder::class]);
        BusinessPartner::factory(\FactoryCount::bpCount)->createQuietly();
        UserDetail::factory(\FactoryCount::userDetailCount)->createQuietly();
        $this->call([BpTypeSeeder::class]);
        Attendance::factory(\FactoryCount::attendanceCount)->createQuietly();

        Schedule::factory(\FactoryCount::scheduleCount)->createQuietly();
        Customer::factory(\FactoryCount::customerCount)->createQuietly();
        // DailyActivity::factory(\FactoryCount::dailyActivityCount)->createQuietly();

        $this->call([BpCustomerSeeder::class]);


        ContactPerson::factory(\FactoryCount::contactCount)->createQuietly();
        Prospect::factory(\FactoryCount::prospectCount)->createQuietly();
    }
}
