<?php

namespace Database\Seeders;

use App\Models\Masters\Stbptype;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Seeder;
use Log;

class BpTypeSeeder extends Seeder
{

   protected $data = [
      [
         'parent' => \DBTypes::prospectStage,
         'sbtname' => 'Prospect Stage',
         'children' => [
            ['sbttypename' => 'Make Contact', 'sbtseq' => 1, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Qualify Compatibility', 'sbtseq' => 2, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Analyze Needs', 'sbtseq' => 3, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Pitch', 'sbtseq' => 4, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Deliver proposal', 'sbtseq' => 5, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Negotiate', 'sbtseq' => 6, 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::prospectStatus,
         'sbtname' => 'Prospect Status',
         'children' => [
            ['sbttypename' => 'Open', 'sbtseq' => 1, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'In Progress', 'sbtseq' => 2,  'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Hold', 'sbtseq' => 3, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Closed', 'sbtseq' => 4, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Closed Won', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Closed Lost', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Force Closed', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::prospectCustLabel,
         'sbtname' => 'Prospect Customer Label',
         'children' => [
            ['sbttypename' => 'Cold', 'sbtseq' => 1, 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Warm', 'sbtseq' => 2,  'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Hot', 'sbtseq' => 3, 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::prospectLostReason,
         'sbtname' => 'Prospect Lost Reason',
         'children' => [
            ['sbttypename' => 'Competitors Prices are Cheaper', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Late Prospect', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Does Not Meet Criteria', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::prospectType,
         'sbtname' => 'Prospect Type',
         'children' => [
            ['sbttypename' => 'Meeting', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Negotiation', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Show Product', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::prospectCategory,
         'sbtname' => 'Prospect Category',
         'children' => [
            ['sbttypename' => 'By Phone', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'By Email', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'By Zoom', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'On Site', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::activitycategory,
         'sbtname' => 'Daily Activity Category',
         'children' => [
            ['sbttypename' => 'Visit Customer', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Meeting at Home', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Meeting at Office', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::activitytype,
         'sbtname' => 'Daily Activity type',
         'children' => [
            ['sbttypename' => 'Department', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Meeting', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Doing Daily Task', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Other', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::contactType,
         'sbtname' => 'Contact Type',
         'children' => [
            ['sbttypename' => 'Phone', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Email', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Facebook', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
      [
         'parent' => \DBTypes::cstmactivitytype,
         'sbtname' => 'Customer Activity Type',
         'children' => [
            ['sbttypename' => 'Clock In First', 'createdby' => 1, 'updatedby' => 1],
            ['sbttypename' => 'Anytime', 'createdby' => 1, 'updatedby' => 1],
         ],
      ],
      [
         'parent' => \DBTypes::cstmtype,
         'sbtname' => 'Customer Type',
         'children' => [
            ['sbttypename' => 'Manufacture', 'createdby' => 1, 'updatedby' => 1],
         ]
      ],
   ];

   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run($id = null)
   {
      if ($id == null) {
         $id = UserDetail::whereHas('user', function ($query) {
            $query->where('username', 'developer');
         })->get()->first()->userdtbpid;
      }

      foreach ($this->data as $data) {
         StBpType::withoutEvents(function () use ($data, $id) {
            $masterid = find_type()->in($data['parent'])->get($data['parent'])->getId();
            foreach ($data['children'] as $child) {
               $type = new Stbptype;
               $typeData = $type->fill(collect($child)->only($type->getFillable())->toArray());
               $typeData->sbtname = $data['sbtname'];
               $typeData->sbtbpid = $id;
               $typeData->sbttypemasterid = $masterid;
               $typeData->save();
            }
         });
      }
   }
}
