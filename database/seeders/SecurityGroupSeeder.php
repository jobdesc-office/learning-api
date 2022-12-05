<?php

namespace Database\Seeders;

use App\Models\Masters\SecurityGroup;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SecurityGroupSeeder extends Seeder
{

    private $data = [
        [
            'sgcode' => "groupindo",
            'sgname' => "Group Indonesia",
            'children' => [
                [
                    'sgcode' => "groupsby",
                    'sgname' => "Group Surabaya",
                    'children' => [
                        [
                            'sgcode' => "groupsbysls",
                            'sgname' => "Group Surabaya Sales",
                        ],
                    ],
                ],
                [
                    'sgcode' => "groupmdn",
                    'sgname' => "Group Madiun",
                    'children' => [
                        [
                            'sgcode' => "groupmdnsls",
                            'sgname' => "Group Madiun Sales",
                        ],
                    ],
                ]
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedChildren(collect($this->data));
    }

    private function seedChildren(Collection $data, SecurityGroup $parent = null)
    {
        $bpid = UserDetail::whereHas('user', function ($query) {
            $query->where('username', 'developer');
        })->get()->first()->userdtbpid;
        foreach ($data as $dt) {
            SecurityGroup::withoutEvents(function () use ($dt, $parent, $bpid) {
                $security_data = collect($dt);
                $security_data = $security_data->merge(['createdby' => 1, 'updatedby' => 1, 'sgbpid' => $bpid]);
                if ($parent != null) $security_data = $security_data->merge(['sgmasterid' => $parent->sgid]);

                $security_group = new SecurityGroup;
                $security_group->fill($security_data->except('children')->toArray())->save();
                if ($security_data->has('children')) $this->seedChildren(collect($security_data->get('children')), $security_group);
            });
        }
    }
}
