<?php

namespace App\Models\Masters;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class AttendanceLocation extends Model
{
    protected $table = "msattendanceloc";
    protected $primaryKey = "attendancelocid";

    protected $fillable = [
        "aluserid",
        "alloclabel",
        "alloc",
        "allatitude",
        "allongitude",
        "createdby",
        "updatedby",
        "isactive"
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public $defaultSelects = array(
        "aluserid",
        "alloclabel",
        "alloc",
        "allatitude",
        "allongitude",
        "createdby",
        "updatedby",
        "isactive"
    );

    /**
     * @param Relation $query
     * @param array|null $selects
     * @return Relation
     * */
    static public function foreignSelect($query, $selects = null)
    {
        $data = new AttendanceLocation();
        return $data->withJoin(is_null($selects) ? $data->defaultSelects : $selects, $query);
    }

    /**
     * @param Relation|AttendanceLocation $query
     * @param array $selects
     * @return Relation
     * */
    private function _withJoin($query, $selects = array())
    {
        return $query->with([])->select('attendancelocid')->addSelect($selects);
    }

    /**
     * @param array $selects
     * @param Relation|AttendanceLocation
     * @return Relation
     * */
    public function withJoin($selects = array(), $query = null)
    {
        return $this->_withJoin(is_null($query) ? $this : $query, $selects);
    }
}

