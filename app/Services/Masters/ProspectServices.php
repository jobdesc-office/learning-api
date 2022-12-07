<?php

namespace App\Services\Masters;

use App\Models\Masters\Prospect;
use App\Models\Masters\ProspectAssign;
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

    public function selectref($id, $searchValue)
    {
        return $this->getQueery()->select('*')
            ->where('prospectbpid', $id)
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
        $users = kacungs();
        $userids = $users->map(function ($item) {
            return $item->userdtid;
        })->toArray();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where(function ($query) use ($prospectwhere, $whereArr, $userids) {
                $query = $query->where($prospectwhere->toArray());
                if ($userids) {
                    $query = $query->orWhereIn('prospectowner', $userids);
                }

                $prospectAssignModel = new ProspectAssign;
                $prospectassignwhere = $whereArr->only($prospectAssignModel->getFillable());
                if ($prospectassignwhere->isNotEmpty()) {
                    $query = $query->orWhereHas('prospectassigns', function ($query) use ($prospectassignwhere, $userids) {
                        $query->where(function ($query) use ($prospectassignwhere, $userids) {
                            $query->orWhere($prospectassignwhere->toArray());
                            if ($userids) {
                                $query = $query->orWhereIn('prospectassignto', $userids);
                                $query = $query->orWhereIn('prospectreportto', $userids);
                            }
                        });
                    });
                }
            });
        }


        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(prospectname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }
        // dd($query->toSql());
        return $query->get();
    }

    public function countAll(Collection $whereArr)
    {
        $query = $this->getQuery();
        $users = kacungs($whereArr->get('groupid'));
        $userids = $users->map(function ($item) {
            return $item->userdtid;
        })->toArray();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where($prospectwhere->toArray());
            if ($userids) {
                $query = $query->orWhereIn('prospectowner', $userids);
            }
        }

        $prospectAssignModel = new ProspectAssign;
        $prospectassignwhere = $whereArr->only($prospectAssignModel->getFillable());
        if ($prospectassignwhere->isNotEmpty()) {
            $query = $query->orWhereHas('prospectassigns', function ($query) use ($prospectassignwhere, $userids) {
                $query->where(function ($query) use ($prospectassignwhere, $userids) {
                    $query->orWhere($prospectassignwhere->toArray());
                    if ($userids) {
                        $query = $query->orWhereIn('prospectassignto', $userids);
                        $query = $query->orWhereIn('prospectreportto', $userids);
                    }
                });
            });
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
            'prospectstage' => function ($query) {
                $query->select('sbtid', 'sbttypename');
            },
            'prospectcustlabeltype' => function ($query) {
                $query->select('sbtid', 'sbttypename');
            },
            'prospectlost' => function ($query) {
                $query->select('sbtid', 'sbttypename');
            },
            // 'prospectownerusers' => function ($query) {
            //     $query->with(['userdetails']);
            // },
            'prospectstatus' => function ($query) {
                $query->select('sbtid', 'sbttypename');
            },
            'prospectlostreason' => function ($query) {
                $query->select('sbtid', 'sbttypename');
            },
            'prospectreference' => function ($query) {
                $query->select('*')->with(['prospectcust']);
            },
            'prospectbp',
            'prospectcustomfield' => function ($query) {
                $query->with(['customfield' => function ($query) {
                    $query->with(['selectoption', 'custftype']);
                }, 'prospect',]);
            },
            'prospectcust' => function ($query) {
                $query->with(['sbccstm']);
            },
        ])->orderBy('createddate', 'desc');
    }

    public function getQueery()
    {
        return $this->newQuery()->with([
            'prospectupdatedby',
            'prospectassigns' => function ($query) {
                $query->select('*')->with(['prospectassignss', 'prospectreportss']);
            },
            'prospectproduct' => function ($query) {
                $query->select('*')->with(['prosproductproduct', 'prosproducttaxtype']);
            },
            'prospectstage' => function ($query) {
                $query->select('sbtid', 'sbttypename', 'sbtseq', 'sbtremark');
            },
            'prospectlost' => function ($query) {
                $query->select('sbtid', 'sbttypename', 'sbtremark');
            },
            'prospectcustlabeltype' => function ($query) {
                $query->select('sbtid', 'sbttypename', 'sbtremark');
            },
            'prospectownerusers' => function ($query) {
                $query->with(['userdetails']);
            },
            'prospectstatus' => function ($query) {
                $query->select('sbtid', 'sbttypename', 'sbtremark');
            },
            'prospectlostreason' => function ($query) {
                $query->select('sbtid', 'sbttypename', 'sbtremark');
            },
            'prospectreference' => function ($query) {
                $query->select('*');
            },
            'prospectby',
            'prospectbp',
            'prospectcustomfield' => function ($query) {
                $query->with(['customfield' => function ($query) {
                    $query->with(['selectoption']);
                }, 'prospect', 'selectedoption']);
            },
            'prospectcust' => function ($query) {
                $query->with(['sbccstm', 'sbccontact' => function ($query) {
                    $query->with(['contacttype']);
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
