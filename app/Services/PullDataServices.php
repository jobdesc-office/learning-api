<?php

namespace App\Services;

class PullDataServices
{
    public function dspbycust() {

        $data = \DB::select("SELECT trp.prospectbpid, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm, msbp.bpname as prospectbpname,
            SUM(trp.prospectvalue) as prospectvalue, msc.sbccstmname as prospectcustname, trp.prospectcustid
            FROM trprospect trp
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbpcustomer msc ON msc.sbcid = trp.prospectcustid
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, prospectcustname, prospectcustid
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbycust")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectcustid" => $data[$i]->prospectcustid,
                "prospectcustname" => $data[$i]->prospectcustname,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbycust")->insert($insert);
    }

    public function dspbycustlabel() {

        $data = \DB::select("SELECT trp.prospectbpid, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm, msbp.bpname as prospectbpname,
            SUM(trp.prospectvalue) as prospectvalue,
            stbpt.sbttypename as prospectcustlabel
            FROM trprospect trp
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt ON stbpt.sbtid = prospectcustlabel
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, stbpt.sbttypename
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbycustlabel")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectcustlabel" => $data[$i]->prospectcustlabel,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbycustlabel")->insert($insert);
    }

    public function dspbycustlabeldt() {

        $data = \DB::select("SELECT trp.prospectbpid, msbp.bpname as prospectbpname, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm,
            SUM(trp.prospectvalue) as prospectvalue,
            stbpt.sbttypename as prospectcustlabel,
            msc.sbcid as prospectcustid, msc.sbccstmname as prospectcustname
            FROM trprospect trp
            JOIN stbpcustomer msc ON msc.sbcid = trp.prospectcustid
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt ON stbpt.sbtid = prospectcustlabel
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, stbpt.sbttypename, msc.sbccstmname, msc.sbcid
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbycustlabeldt")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectcustid" => $data[$i]->prospectcustid,
                "prospectcustname" => $data[$i]->prospectcustname,
                "prospectcustlabel" => $data[$i]->prospectcustlabel,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbycustlabeldt")->insert($insert);
    }

    public function dspbyowner() {

        $data = \DB::select("SELECT trp.prospectbpid, msbp.bpname as prospectbpname, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm,
            SUM(trp.prospectvalue) as prospectvalue,
            trp.prospectowner as prospectownerid, msu.userfullname as prospectowner,
            stbpt.sbttypename as prospectstatus, stbpt2.sbttypename as prospectstage
            FROM trprospect trp
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt ON stbpt.sbtid = trp.prospectstatusid
            JOIN stbptype stbpt2 ON stbpt2.sbtid = trp.prospectstageid
            JOIN msuser msu ON msu.userid = trp.prospectowner
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, trp.prospectowner, msu.userfullname, stbpt.sbttypename, stbpt2.sbttypename
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbyowner")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectownerid" => $data[$i]->prospectownerid,
                "prospectowner" => $data[$i]->prospectowner,
                "prospectstatus" => $data[$i]->prospectstatus,
                "prospectstage" => $data[$i]->prospectstage,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbyowner")->insert($insert);
    }

    public function dspbystage() {

        $data = \DB::select("SELECT trp.prospectbpid, msbp.bpname as prospectbpname, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm,
            SUM(trp.prospectvalue) as prospectvalue,
            stbpt2.sbttypename as prospectstage
            FROM trprospect trp
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt2 ON stbpt2.sbtid = trp.prospectstageid
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, stbpt2.sbttypename
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbystage")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectstage" => $data[$i]->prospectstage,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbystage")->insert($insert);
    }

    public function dspbystagedt() {

        $data = \DB::select("SELECT trp.prospectbpid, msbp.bpname as prospectbpname, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm,
            SUM(trp.prospectvalue) as prospectvalue,
            stbpt2.sbttypename as prospectstage,
            msc.sbcid as prospectcustid, msc.sbccstmname as prospectcustname
            FROM trprospect trp
            JOIN stbpcustomer msc ON msc.sbcid = trp.prospectcustid
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt2 ON stbpt2.sbtid = trp.prospectstageid
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, stbpt2.sbttypename, msc.sbccstmname, msc.sbcid
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbystagedt")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectcustid" => $data[$i]->prospectcustid,
                "prospectcustname" => $data[$i]->prospectcustname,
                "prospectstage" => $data[$i]->prospectstage,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbystagedt")->insert($insert);
    }

    public function dspbystatus() {

        $data = \DB::select("SELECT trp.prospectbpid, msbp.bpname as prospectbpname, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm,
            SUM(trp.prospectvalue) as prospectvalue,
            stbpt.sbttypename as prospectstatus
            FROM trprospect trp
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt ON stbpt.sbtid = trp.prospectstatusid
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, stbpt.sbttypename
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbystatus")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectstatus" => $data[$i]->prospectstatus,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbystatus")->insert($insert);
    }

    public function dspbystatusdt() {

        $data = \DB::select("SELECT trp.prospectbpid, msbp.bpname as prospectbpname, EXTRACT('YEAR' FROM prospectstartdate) as prospectyy,
            EXTRACT('MONTH' FROM prospectstartdate) as prospectmm,
            SUM(trp.prospectvalue) as prospectvalue,
            stbpt.sbttypename as prospectstatus,
            msc.sbcid as prospectcustid, msc.sbccstmname as prospectcustname
            FROM trprospect trp
            JOIN stbpcustomer msc ON msc.sbcid = trp.prospectcustid
            JOIN msbusinesspartner msbp ON msbp.bpid = trp.prospectbpid
            JOIN stbptype stbpt ON stbpt.sbtid = trp.prospectstatusid
            GROUP BY prospectbpid, prospectyy, prospectmm, prospectbpname, stbpt.sbttypename, msc.sbccstmname, msc.sbcid
            ORDER BY trp.prospectbpid");

        \DB::connection("pgsql2")->table("dspbystatusdt")->delete();

        $insert = [];
        for ($i = 0; $i < count($data); $i++) {
            $insert[] = [
                "prospectbpid" => $data[$i]->prospectbpid,
                "prospectbpname" => $data[$i]->prospectbpname,
                "prospectcustid" => $data[$i]->prospectcustid,
                "prospectcustname" => $data[$i]->prospectcustname,
                "prospectstatus" => $data[$i]->prospectstatus,
                "prospectyy" => $data[$i]->prospectyy,
                "prospectmm" => $data[$i]->prospectmm,
                "prospectvalue" => $data[$i]->prospectvalue,
            ];
        }

        \DB::connection("pgsql2")->table("dspbystatusdt")->insert($insert);
    }
}
