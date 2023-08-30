<?php

namespace App\Http\Controllers;

use App\Models\Masters\DspByCust;
use App\Models\Masters\DspByCustLabel;
use App\Services\PullDataServices;

class PullDataController extends Controller
{
    public function pullData(PullDataServices $pullDataServices) {
        try {
            $pullDataServices->dspbycust();
            $pullDataServices->dspbycustlabel();
            $pullDataServices->dspbycustlabeldt();
            $pullDataServices->dspbyowner();
            $pullDataServices->dspbystage();
            $pullDataServices->dspbystagedt();
            $pullDataServices->dspbystatus();
            $pullDataServices->dspbystatusdt();
        } catch (\Exception $exception) {
            echo "Failed to process data: " . $exception->getMessage();
        }
    }
}
