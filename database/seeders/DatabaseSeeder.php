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

        $bptype = find_type()->byCode([\DBTypes::businessPartner, \DBTypes::menuType])
            ->children(\DBTypes::menuType);
        $types = find_type()->in([\DBTypes::roleSuperAdmin, \DBTypes::role]);

        BusinessPartner::factory(5)->create(['bptypeid' => $bptype->random()->getId()]);
        User::factory(1)->create(['username' => 'developer']);
        UserDetail::factory(1)->create(['userid' => 1, 'userdttypeid' => $types->get(\DBTypes::roleSuperAdmin)->getId()]);
    }
}
