<?php

namespace App\Services\Masters;

use App\Models\Masters\Prospect;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use DBTypes;

class ProspectServices extends Prospect
{

    public function lastid()
    {
        return $this->getQueery()->get()->last();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this->getQueery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function datatablesbp($id, $order, $orderby, $search)
    {
        return $this->getQueery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->where('prospectbpid', $id)
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function found($id)
    {
        return $this->getQueery()->findOrFail($id);
    }

    public function select($searchValue)
    {
        return $this->getQueery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(prospectname))'), 'like', "%$searchValue%");
            })
            ->orderBy('prospectname', 'asc')
            ->get();
    }

    public function selectref($searchValue)
    {
        return $this->getQueery()->select('*')
            ->where('prospectrefid', null)
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(prospectname))'), 'like', "%$searchValue%");
            })
            ->orderBy('prospectname', 'asc')
            ->get();
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where($prospectwhere->toArray());
        }

        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(prospectname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function countAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where($prospectwhere->toArray());
        }

        return $query->count();
    }

    public function generateCode()
    {
        $code = "PRS";

        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');

        $count = Prospect::count() + 1;
        $increment = str_pad($count, 4, "0", STR_PAD_LEFT);

        return "$code$year$month$increment";;
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'prospectowneruser' => function ($query) {
                $query->with(['user']);
            },
            'prospectassigns' => function ($query) {
                $query->select('*')->with(['prospectassign' => function ($query) {
                    $query->with(['user']);
                }, 'prospectreport' => function ($query) {
                    $query->with(['user']);
                }]);
            },
            'prospectproduct' => function ($query) {
                $query->select('*')->with(['prosproductproduct', 'prosproducttaxtype']);
            },
            'prospectcustlabel' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectstage' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectcustlabeltype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectlost' => function ($query) {
                $query->select('typeid', 'typename');
            },
            // 'prospectownerusers' => function ($query) {
            //     $query->with(['userdetails']);
            // },
            'prospectstatus' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectlostreason' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectreference' => function ($query) {
                $query->select('*')->with(['prospectcust']);
            },
            'prospectbp',
            'prospectcustomfield' => function ($query) {
                $query->with(['customfield', 'prospect']);
            },
            'prospectcust' => function ($query) {
                $query->with(['sbccstm']);
            },
        ]);
    }

    public function getQueery()
    {
        return $this->newQuery()->with([
            'prospectassigns' => function ($query) {
                $query->select('*')->with(['prospectassignss', 'prospectreportss']);
            },
            'prospectproduct' => function ($query) {
                $query->select('*')->with(['prosproductproduct', 'prosproducttaxtype']);
            },
            'prospectstage' => function ($query) {
                $query->select('typeid', 'typename', 'typeseq');
            },
            'prospectlost' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectownerusers' => function ($query) {
                $query->with(['userdetails']);
            },
            'prospectstatus' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectlostreason' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectreference' => function ($query) {
                $query->select('*');
            },
            'prospectby',
            'prospectbp',
            'prospectcustomfield' => function ($query) {
                $query->with(['customfield', 'prospect']);
            },
            'prospectcust' => function ($query) {
                $query->with(['sbccstm' => function ($query) {
                    $query->with(['cstmcontact' => function ($query) {
                        $query->with(['contacttype']);
                    }]);
                }]);
            },
            'prospectfiles' => function ($query) {
                $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('typecd', DBTypes::prospectfile);
                    });
            },
        ]);
    }
}
