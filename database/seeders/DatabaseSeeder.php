<?php

namespace Database\Seeders;

use App\Models\BusinessPartners\BusinessPartner;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Seeder;

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

        $bptype = find_type()->byCode(\DBTypes::businessPartner)
            ->children();
        $types = find_type()->in([\DBTypes::roleSuperAdmin]);

        BusinessPartner::factory(5)->create(['bptypeid' => $bptype->random()->getId()]);
        User::factory(1)->create(['username' => 'developer']);
        UserDetail::factory(1)->create(['userid' => 1, 'usertypeid' => $types->get(\DBTypes::roleSuperAdmin)->getId()]);

    }
}
