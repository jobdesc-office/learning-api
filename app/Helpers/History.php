<?php

use App\Models\DefaultModel;
use App\Models\Masters\TbHistory;
use App\Models\Masters\TrHistory;
use App\Models\Masters\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class History
{
   const DEFAULT_REMARK = "FIELD value has been changed from \"VALUE.OLD\" to \"VALUE.NEW\" at DATE by USER";
   const UNTRACKABLE_FIELD = ['createddate', 'updateddate', 'createdby', 'updatedby', 'isactive'];

   /**
    * @var DefaultModel
    */
   private $oldModel;

   /**
    * @var DefaultModel
    */
   private $newModel;

   /**
    * @var string
    * table name
    */
   public $tableName;

   /**
    * @var string
    */
   public $remark;

   /**
    * @var boolean
    */
   private $createParentIfNull;

   /**
    * @param DefaultModel $oldModel
    * @param DefaultModel $newModel
    * @param boolean $createIfNull create parent if null
    * @param string|null $remark remark should contains VALUE.OLD, VALUE.NEW, FIELD, DATE , USER
    */
   public function __construct($oldModel, $newModel, $createParentIfNull = true, $remark = null)
   {
      $this->remark = $remark;
      $this->oldModel = $oldModel;
      $this->newModel = $newModel;
      $this->createParentIfNull = $createParentIfNull;

      $this->tableName = $oldModel->getTable();
   }

   public function store()
   {
      $newData = $this->newModel->toArray();

      $histories = collect($newData)->map(function ($value, $field) {
         if ($this->oldModel->getAttribute($field) != $value && !in_array($field, History::UNTRACKABLE_FIELD)) {
            return [$field, $this->oldModel->getAttribute($field), $value];
         }
         return null;
      });
      $histories = $histories->filter();

      foreach ($histories->toArray() as $value) {
         $fieldname = $value[0];
         $oldValue = $value[1];
         $newValue = $value[2];

         $tbHistory = $this->findOrCreate($fieldname);
         if ($tbHistory != null) $this->createHistory($tbHistory, $oldValue, $newValue);
      }
   }

   /**
    * @return TbHistory|null
    */
   private function findOrCreate($fieldname)
   {
      $tbname = $this->oldModel->getTable();
      $aliasField = $this->oldModel->getAlias($fieldname);

      if ($aliasField != null) {
         $data = [
            'tbhistorytbname' => $tbname,
            'tbhistorytbfield' => $fieldname,
            'tbhistoryasfield' => $aliasField,
            'tbhistoryremarkformat' => History::DEFAULT_REMARK,
            'createdby' => auth()->user()->id,
         ];
         if ($this->remark != null) $data['tbhistoryremarkformat'] = $this->remark;

         $historyParent = TbHistory::where($data)->get();

         if ($historyParent->count() > 0) {
            return $historyParent->first();
         } else {
            if ($this->createParentIfNull) {
               $tbHistory = new TbHistory();
               $tbHistory->fill($data);
               $tbHistory->save();

               return $tbHistory;
            }
            return null;
         }
      }
      return null;
   }

   /**
    * @param TbHistory $tbhistory
    */
   private function createHistory($tbhistory, $oldvalue, $newvalue)
   {
      $remark = $tbhistory->tbhistoryremarkformat;
      $remark = Str::replace('VALUE.OLD', $oldvalue, $remark);
      $remark = Str::replace('VALUE.NEW', $newvalue, $remark);
      $remark = Str::replace('FIELD', $tbhistory->tbhistoryasfield, $remark);
      $remark = Str::replace('USER', auth()->user()->userfullname, $remark);

      $date = Carbon::now()->format('F d ,Y h:i A');
      $remark = Str::replace('DATE', $date, $remark);

      $data = [
         "historytbhistoryid" => $tbhistory->tbhistoryid,
         "historyrefid" => $this->newModel->getId(),
         "historyremark" => $remark,
         "historyoldvalue" => $oldvalue,
         "historynewvalue" => $newvalue,
         "historybpid" => request()->header('bpid'),
         "historysource" => Auth::getPayload()->get('source'),
         "createdby" => Auth::user()->userid,
      ];

      $trHistory = new TrHistory();
      $trHistory->fill($data);
      return $trHistory->save();
   }
}
