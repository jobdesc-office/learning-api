<?php

namespace Database\Seeders;

use App\Models\Security\Menu;
use App\Models\Security\Feature;
use App\Models\Security\Permission;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Seeder;
use Log;
use TextMessages;

class PermissionSeeder extends Seeder
{

   protected $data = [
      [
         'menutypeid' => \DBTypes::webb,
         'menunm' => 'Insight',
         'menuicon' => 'Icons.extension',
         'createdby' => 1,

         'children' => [
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Dashboard', 'menuicon' => 'Icons.dashboard', 'menuroute' => '/', 'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
         ],
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::webb,
         'menunm' => 'Master Datas',
         'menuicon' => 'Icons.storage_outlined',
         'createdby' => 1,

         'children' => [
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Business Partner',
               'menuicon' => 'Icons.handshake',
               'menuroute' => '/masters/businesspartner',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Role',
               'menuicon' => 'Icons.group',
               'menuroute' => '/masters/role',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
         ],
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::webb,
         'menunm' => 'Settings',
         'menuicon' => 'Icons.settings_outlined',
         'createdby' => 1,

         'children' => [
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Security Group',
               'menuicon' => 'Icons.group',
               'menuroute' => '/masters/securitygroup',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Types',
               'menuicon' => 'Icons.category',
               'createdby' => 1,
               'menuroute' => '/-type',
               'children' => [
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Type Parents',
                     'menuicon' => 'Icons.category',
                     'menuroute' => '/masters/typeparent',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Type Datas',
                     'menuicon' => 'Icons.square',
                     'menuroute' => '/masters/typechildren',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
               ],
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Regions',
               'menuicon' => 'FontAwesomeIcons.earthAmerica',
               'createdby' => 1,
               'menuroute' => '/-region',
               'children' => [
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Countries',
                     'menuicon' => 'FontAwesomeIcons.globe',
                     'menuroute' => '/masters/country',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Provinces',
                     'menuicon' => 'FontAwesomeIcons.earthAmerica',
                     'menuroute' => '/masters/province',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Cities',
                     'menuicon' => 'FontAwesomeIcons.city',
                     'menuroute' => '/masters/city',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Subdistricts',
                     'menuicon' => 'FontAwesomeIcons.city',
                     'menuroute' => '/masters/subdistrict',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::webb,
                     'menunm' => 'Villages',
                     'menuicon' => 'FontAwesomeIcons.city',
                     'menuroute' => '/masters/village',
                     'createdby' => 1,

                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                        [
                           'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ],
                     ],
                  ],
               ],
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Files',
               'menuicon' => 'Icons.file_open',
               'menuroute' => '/settings/files',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Informations',
               'menuicon' => 'Icons.info',
               'menuroute' => '/settings/information',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Permission',
               'menuicon' => 'Icons.key',
               'menuroute' => '/settings/permission',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Company Setting',
               'menuicon' => 'Icons.domain',
               'menuroute' => '/settings/company',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
         ],
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::webb,
         'menunm' => 'Ventes Datas',
         'menuicon' => 'Icons.analytics',
         'createdby' => 1,

         'children' => [
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Prospect',
               'menuicon' => 'Icons.analytics',
               'menuroute' => '/ventes/prospect',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Schedule',
               'menuicon' => 'FontAwesomeIcons.calendarDays',
               'menuroute' => '/ventes/schedule',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Report Activity',
               'menuicon' => 'FontAwesomeIcons.addressBook',
               'menuroute' => '/ventes/report',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::webb,
               'menunm' => 'Chat',
               'menuicon' => 'Icons.chat',
               'menuroute' => '/ventes/chat',
               'createdby' => 1,

               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
         ],
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],

      // Mobile Menus 

      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'dashboard',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ]
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'chat',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ]
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'dailyactivity',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'customer',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'schedule',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'attendance',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'prospect',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
            [
               'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
               ],
            ],
         ],
         'children' =>  [
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'prospect activity',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'prospect competitor',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'prospect product',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'prospect contacts',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'prospect assign',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Create', 'featslug' => 'create', 'featuredesc' => \TextMessages::create, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Update', 'featslug' => 'update', 'featuredesc' => \TextMessages::update, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
                  [
                     'feattitle' => 'Delete', 'featslug' => 'delete', 'featuredesc' => \TextMessages::delete, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ],
               ],
            ],
         ],
      ],
      [
         'menutypeid' => \DBTypes::appss,
         'menunm' => 'insight',
         'createdby' => 1,
         'features' => [
            [
               'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
               'permission' => [
                  ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                  ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
               ],
            ]
         ],
         'children' => [
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'insight 1',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ]
               ],
               'children' => [
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'total value',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'total won',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'total lost',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'value by customer',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'value by stage',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'value by customer label',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::spv, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
               ],
            ],
            [
               'menutypeid' => \DBTypes::appss,
               'menunm' => 'insight 2',
               'createdby' => 1,
               'features' => [
                  [
                     'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                     'permission' => [
                        ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                        ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                     ],
                  ]
               ],
               'children' => [
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'total value',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'total won',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
                  [
                     'menutypeid' => \DBTypes::appss,
                     'menunm' => 'total lost',
                     'createdby' => 1,
                     'features' => [
                        [
                           'feattitle' => 'Viewable', 'featslug' => 'viewable', 'featuredesc' => \TextMessages::viewable, 'createdby' => 1,
                           'permission' => [
                              ['roleid' => \DBTypes::admin, 'hasaccess' => true, 'createdby' => 1],
                              ['roleid' => \DBTypes::marsa, 'hasaccess' => true, 'createdby' => 1],
                           ],
                        ]
                     ],
                  ],
               ],
            ],
         ],
      ],
   ];

   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run(Menu $menu, Feature $feature, Permission $permission)
   {
      foreach ($this->data as $data) {
         $menu->withoutEvents(function () use ($data, $menu, $feature, $permission) {
            $parent = $menu->create(collect($data)->only($menu->getFillable())->toArray());

            if (isset($data['features']))
               $this->seedFeature($feature, $permission, $parent->menuid, $data['features']);

            if (isset($data['children']))
               $this->seedChildren($menu, $feature, $permission, $parent->menuid, $data['children']);
         });
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
   public function seedChildren(Menu $menu, Feature $feature, Permission $permission, $parentId, array $children)
   {
      foreach ($children as $child) {
         $menu->withoutEvents(function () use ($parentId, $child, $menu, $feature, $permission) {
            $child['masterid'] = $parentId;
            $result = $menu->create(collect($child)->only($menu->getFillable())->toArray());
            if (isset($child['features']))
               $this->seedFeature($feature, $permission, $result->menuid, $child['features']);

            if (isset($child['children']))
               $this->seedChildren($menu, $feature, $permission, $result->menuid, $child['children']);
         });
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
   public function seedFeature(Feature $feature, Permission $permission, $menu, array $children)
   {
      foreach ($children as $child) {
         $feature->withoutEvents(function () use ($menu, $child, $feature, $permission) {
            $child['featmenuid'] = $menu;
            $result = $feature->create(collect($child)->only($feature->getFillable())->toArray());

            if (isset($child['permission']))
               $this->seedPermission($permission, $menu, $result->featid, $child['permission']);
         });
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
   public function seedPermission(Permission $permission, $menu, $feat, array $children)
   {
      foreach ($children as $child) {
         $permission->withoutEvents(function () use ($menu, $feat, $child, $permission) {
            $child['permismenuid'] = $menu;
            $child['permisfeatid'] = $feat;
            $result = $permission->create(collect($child)->only($permission->getFillable())->toArray());
         });
      }
   }
}
