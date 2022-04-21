<?php

namespace Database\Seeders;

use App\Models\Masters\Types;
use DBTypes;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{

    protected $data = [
        [
            'typecd' => \DBTypes::role,
            'typename' => 'Role',
            'children' => [
                ['typecd' => \DBTypes::roleSuperAdmin, 'typename' => 'Super Admin', 'createdby' => 1, 'updatedby' => 1],
            ],
            'createdby' => 1,
            'updatedby' => 1,
        ],
        [
            'typecd' => \DBTypes::businessPartner,
            'typename' => 'Tipe Business Partner',
            'children' => [
                ['typename' => 'Otomotif', 'createdby' => 1, 'updatedby' => 1],
                ['typename' => 'Manufaktur', 'createdby' => 1, 'updatedby' => 1],
            ],
            'createdby' => 1,
            'updatedby' => 1,
        ],
        [
            'typecd' => \DBTypes::menuType,
            'typename' => 'Menu Type',
            'children' => [
                ['typename' => 'Web', 'createdby' => 1, 'updatedby' => 1],
                ['typename' => 'Apps', 'createdby' => 1, 'updatedby' => 1],
            ]
        ],
        [
            'typecd' => \DBTypes::schedule,
            'typename' => 'Schedule',
            'children' => [
                ['typename' => 'Task', 'typecd' => DBTypes::scheduleTask, 'createdby' => 1, 'updatedby' => 1,],
                ['typename' => 'Event', 'typecd' => DBTypes::scheduleEvent, 'createdby' => 1, 'updatedby' => 1],
                ['typename' => 'Reminder', 'typecd' => DBTypes::scheduleReminder, 'createdby' => 1, 'updatedby' => 1],
            ]
        ],
        [
            'typecd' => \DBTypes::schedulePermission,
            'typename' => 'Schedule Permission',
            'children' => [
                ['typename' => 'Read Only', 'createdby' => 1, 'updatedby' => 1],
                ['typename' => 'Add Member', 'createdby' => 1, 'updatedby' => 1],
                ['typename' => 'Share Link', 'createdby' => 1, 'updatedby' => 1],
            ]
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @param Types|Relation $type
     *
     * @return void
     */
    public function run(Types $type)
    {
        foreach ($this->data as $data) {
            $parent = $type->create(collect($data)->only($type->getFillable())->toArray());
            if (isset($data['children']))
                $this->seedChildren($type, $parent->typeid, $data['children']);
        }
    }

    /**
     * Run the database seeds.
     *
     * @param Types|Relation $config
     * @param mixed $parentId
     * @param array $children
     *
     * @return void
     */
    public function seedChildren(Types $config, $parentId, array $children)
    {
        foreach ($children as $child) {
            $child['typemasterid'] = $parentId;
            $result = $config->create(collect($child)->only($config->getFillable())->toArray());

            if (isset($child['children']))
                $this->seedChildren($config, $result->typeid, $child['children']);
        }
    }
}
