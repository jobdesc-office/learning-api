<?php

namespace Database\Factories;

use App\Models\Masters\BusinessPartner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessPartnerFactory extends Factory
{

    protected $model = BusinessPartner::class;

    public function definition()
    {
        return [
            'bpname' => $this->faker->company(),
            'bppicname' => $this->faker->name(),
            'bpemail' => $this->faker->email(),
            'bpphone' => $this->faker->phoneNumber(),
            'bpactanytime' => true,
            'bptypeid' => find_type()->byCode([\DBTypes::businessPartner])->children(\DBTypes::businessPartner)->random()->getId(),
            'createdby' => 1,
            'updatedby' => 1,
        ];
    }
}
