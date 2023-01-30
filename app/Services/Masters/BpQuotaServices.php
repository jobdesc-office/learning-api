<?php

namespace App\Services\Masters;

use App\Models\Masters\BpCustomer;
use App\Models\Masters\BpQuota;
use App\Models\Masters\ContactPerson;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Product;
use App\Models\Masters\Prospect;
use App\Models\Masters\ProspectProduct;
use App\Models\Masters\User;
use DBTypes;
use PDO;

class BpQuotaServices extends BpQuota
{
   public function isAllowAddWebUser($userCount)
   {
      $types = find_type()->in([DBTypes::webAccess, DBTypes::allAccess]);
      $typesid = [$types->get(DBTypes::webAccess)->getId(), $types->get(DBTypes::allAccess)->getId()];
      $users = User::whereHas('userdetails', function ($query) {
         $query->where('userdtbpid', request()->header('bpid'));
      })->whereIn('userappaccess', $typesid)->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $userCount + $users <= $quota->sbqwebuserquota;
      }
      return false;
   }

   public function isAllowAddMobileUser($userCount)
   {
      $types = find_type()->in([DBTypes::mobileAccess, DBTypes::allAccess]);
      $typesid = [$types->get(DBTypes::mobileAccess)->getId(), $types->get(DBTypes::allAccess)->getId()];
      $users = User::whereHas('userdetails', function ($query) {
         $query->where('userdtbpid', request()->header('bpid'));
      })->whereIn('userappaccess', $typesid)->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $userCount + $users <= $quota->sbqmobuserquota;
      }
      return false;
   }

   public function isAllowAddUser($userCount)
   {
      return $this->isAllowAddMobileUser($userCount) && $this->isAllowAddWebUser($userCount);
   }

   public function isAllowAddCustomer($customerCount)
   {
      $customers = BpCustomer::where('sbcbpid', request()->header('bpid'))->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $customerCount + $customers <= $quota->sbqcstmquota;
      }
      return false;
   }

   public function isAllowAddContact($contactCount)
   {
      $contacts = ContactPerson::whereHas('contactcustomer', function ($query) {
         $query->where('sbcbpid', request()->header('bpid'));
      })->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $contactCount + $contacts <= $quota->sbqcntcquota;
      }
      return false;
   }

   public function isAllowAddProduct($productCount)
   {
      $products = Product::where('productbpid', request()->header('bpid'))->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $productCount + $products <= $quota->sbqprodquota;
      }
      return false;
   }

   public function isAllowAddProspect($prospectCount)
   {
      $prospects = Prospect::where('prospectbpid', request()->header('bpid'))->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $prospectCount + $prospects <= $quota->sbqprosquota;
      }
      return false;
   }

   public function isAllowAddDailyActivity($dayactCount)
   {
      $dayacts = DailyActivity::whereNull('dayactreftypeid')->whereHas('dayactuser', function ($query) {
         $query->whereHas('userdetails', function ($query) {
            $query->where('userdtbpid', request()->header('bpid'));
         });
      })->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $dayactCount + $dayacts <= $quota->sbqdayactquota;
      }
      return false;
   }

   public function isAllowAddProspectActivity($prosactCount)
   {
      $typeid = find_type()->in([DBTypes::dayactreftypeprospect])->get(DBTypes::dayactreftypeprospect)->getId();
      $prosacts = DailyActivity::where('dayactreftypeid', $typeid)->whereHas('dayactuser', function ($query) {
         $query->whereHas('userdetails', function ($query) {
            $query->where('userdtbpid', request()->header('bpid'));
         });
      })->count();
      $quota = $this->getQuotas();
      if ($quota) {
         return $prosactCount + $prosacts <= $quota->sbqprosactquota;
      }
      return false;
   }

   public function getQuotas()
   {
      $quota  = $this->newQuery()->where('sbqbpid', request()->header('bpid'))->get();
      if ($quota->isEmpty()) return null;
      return $quota->first();
   }

   public function getQuotaDetail()
   {
      $quota  = $this->newQuery()->where('sbqbpid', request()->header('bpid'))->get();
      if ($quota->isEmpty()) return null;

      $types = find_type()->in([DBTypes::webAccess, DBTypes::allAccess, DBTypes::mobileAccess]);
      $webtypesid = [$types->get(DBTypes::webAccess)->getId(), $types->get(DBTypes::allAccess)->getId()];
      $mobtypesid = [$types->get(DBTypes::mobileAccess)->getId(), $types->get(DBTypes::allAccess)->getId()];

      $webusers = User::whereHas('userdetails', function ($query) {
         $query->where('userdtbpid', request()->header('bpid'));
      })->whereIn('userappaccess', $webtypesid)->count();
      $mobileusers = User::whereHas('userdetails', function ($query) {
         $query->where('userdtbpid', request()->header('bpid'));
      })->whereIn('userappaccess', $mobtypesid)->count();
      $customers = BpCustomer::where('sbcbpid', request()->header('bpid'))->count();
      $contacts = ContactPerson::whereHas('contactcustomer', function ($query) {
         $query->where('sbcbpid', request()->header('bpid'));
      })->count();
      $products = Product::where('productbpid', request()->header('bpid'))->count();
      $prospects = Prospect::where('prospectbpid', request()->header('bpid'))->count();
      $dayacts = DailyActivity::whereNull('dayactreftypeid')->whereHas('dayactuser', function ($query) {
         $query->whereHas('userdetails', function ($query) {
            $query->where('userdtbpid', request()->header('bpid'));
         });
      })->count();
      $typeid = find_type()->in([DBTypes::dayactreftypeprospect])->get(DBTypes::dayactreftypeprospect)->getId();
      $prosacts = DailyActivity::where('dayactreftypeid', $typeid)->whereHas('dayactuser', function ($query) {
         $query->whereHas('userdetails', function ($query) {
            $query->where('userdtbpid', request()->header('bpid'));
         });
      })->count();

      $quotaDetail =  $quota->first();
      $quotaDetail->sbqwebuserquotaused = $webusers;
      $quotaDetail->sbqmobuserquotaused = $mobileusers;
      $quotaDetail->sbqcstmquotaused = $customers;
      $quotaDetail->sbqcntcquotaused = $contacts;
      $quotaDetail->sbqprodquotaused = $products;
      $quotaDetail->sbqprosquotaused = $prospects;
      $quotaDetail->sbqdayactquotaused = $dayacts;
      $quotaDetail->sbqprosactquotaused = $prosacts;
      return $quotaDetail;
   }
}
